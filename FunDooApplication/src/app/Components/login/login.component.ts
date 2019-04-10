import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { LoginService } from "src/app/Services/loginService/ServiceLogin";
import { Router } from '@angular/router';

import {
	AuthServiceConfig,
	FacebookLoginProvider,
	GoogleLoginProvider,
  AuthService,
  SocialUser
} from "angular-6-social-login";
import { CookieService } from 'ngx-cookie-service';
import { NgxTwitterTimelineModule } from 'ngx-twitter-timeline';
@Component({

  selector: 'app-login',

  templateUrl: './login.component.html',

  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  constructor(private cookieserv:CookieService 
    ,private userData:SocialUser,private socAuthService: AuthService,private logService: LoginService, private route: Router) { }

  model: any;

  email = new FormControl('', [Validators.required, Validators.email]);

  password = new FormControl('', [Validators.required]);

  ngOnInit() {
  }
	/**
	 * @method login()
	 * @return void
	 * @description Function to error validation
	 */
  login() {
    this.model = {

      "email": this.email.value,

      "password": this.password.value,

    }
    if (this.email.value == '' || this.password.value == '') {

      alert("Fields are missing");

    }
    else {

      console.log(this.model);

      let obj = this.logService.userLogin(this.model);

      obj.subscribe((res: any) => {
        console.log(res.message);

        if (res.message == "200") {

          const tokens = res.token;
          localStorage.setItem("token", tokens);
          localStorage.setItem("email", this.email.value);
          localStorage.setItem(this.email.value, this.password.value);
          alert("logged in succesfully!!! ");

          this.route.navigate(['/home']);

        } else if (res.message == "204") {

          alert("enter valid password");

        } else if (res.message == "400") {

          alert("Invalid email");
        }

      });
    }
  }


  usingSocialSignIn(sociallogin: string) {
		let socialservice;
		if (sociallogin == "facebook") {
			socialservice = FacebookLoginProvider.PROVIDER_ID;
		} else if (sociallogin == "google") {
      socialservice = GoogleLoginProvider.PROVIDER_ID;
    }
		// }else if (sociallogin == "twitter") {
		// 	socialservice = twitterConsumerSecretKey.PROVIDER_ID;
		// }

		this.socAuthService.signIn(socialservice).then(
      (userData) => {
        console.log(sociallogin+" sign in data : " , userData);
        // Now sign-in with userData   
        this.saveSocialUser(userData.name,userData.email,userData.image,userData.token)

      }
		);
	}



saveSocialUser(name,email,image,token){

    let socialres = this.logService.socialLogin(email,name);
    socialres.subscribe((res:any)=>{
debugger
      console.log(res);
      if(res.message=="200"){ 
        
        this.cookieserv.set("email",email);

        this.cookieserv.set("image",image);
        localStorage.setItem("token",res.token);
        localStorage.setItem("email",email);
        localStorage.setItem("name",name);
        this.route.navigate(["/home"]);
      }
    })
}
}
