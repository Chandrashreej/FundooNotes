import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { LoginService } from "src/app/Services/loginService/ServiceLogin";
import { Router } from '@angular/router';

@Component({

  selector: 'app-login',

  templateUrl: './login.component.html',

  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  constructor(private logService: LoginService, private route: Router) { }

  model: any;

  email = new FormControl('', [Validators.required, Validators.email]);

  password = new FormControl('', [Validators.required]);

  ngOnInit() {
  }

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

          localStorage.setItem(this.email.value, this.password.value);
          alert("logged in succesfully!!! ");

          this.route.navigate(['/dashboard']);

        } else if (res.message == "204") {

          alert("enter valid password");

        } else if (res.message == "400") {

          alert("Invalid email");
        }
        
      });
    }
  }
}
