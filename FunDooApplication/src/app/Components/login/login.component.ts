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

@Component({

  selector: 'app-login',

  templateUrl: './login.component.html',

  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  constructor(private cookieserv:CookieService 
    ,private userData:SocialUser,private socialAuthService: AuthService,private logService: LoginService, private route: Router) { }

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
        debugger;
        console.log(res.message);
        debugger;
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
  	/**
	 * @method socialSignIn()
	 * @return void
	 * @param socialPlatform
	 * @description Function to error validation
	 */

	public socialSignIn(socialPlatform: string) {
		debugger;
		let socialPlatformProvider;
		if (socialPlatform == "facebook") {
			socialPlatformProvider = FacebookLoginProvider.PROVIDER_ID;
		} else if (socialPlatform == "google") {
			socialPlatformProvider = GoogleLoginProvider.PROVIDER_ID;
		}

		this.socialAuthService.signIn(socialPlatformProvider).then(
      (userData) => {
        debugger
        console.log(socialPlatform+" sign in data : " , userData);
        // Now sign-in with userData   
        this.saveSocialUser(userData.name,userData.email,userData.image,userData.token)

      }
		);
	}

	/**
	 * @method sendToRestApiMethod()
	 * @return void
	 * @param token
	 * @param email
	 * @param image
	 * @param name
	 * @description Function to error validation
	 */

  message
saveSocialUser(name,email,image,token){
  debugger
    let socialres = this.logService.socialLogin(email,name);
    socialres.subscribe((res:any)=>{
      debugger
      console.log(res);
      if(res.message=="200"){ 
        this.cookieserv.set("email",email);

        this.cookieserv.set("image",image);
        localStorage.setItem("token",token);
        localStorage.setItem("email",email);
        localStorage.setItem("name",name);
        this.route.navigate(["/home"]);
      }
    })
}
}


