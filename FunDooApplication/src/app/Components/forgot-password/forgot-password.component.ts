import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { LoginService } from 'src/app/Services/loginService/ServiceLogin';
import { Router } from '@angular/router';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {

  constructor(private serviceLogin: LoginService, private route: Router) { }

  model: any = {};
  usererror: string = "";
  email = new FormControl("", [Validators.required, Validators.email]);
  ngOnInit() {
  }

  forgotPassword() {
    let obj = this.serviceLogin.userForgotPasswordData(this.model);
    obj.subscribe((res: any) => {
      if (res.message == "200") {

        this.result;
        alert("To reset go to your email for the link");

      } else if(res.message == "204"){
        alert("Email hasen't registered yet");
      }
    });
  }
  result(){
    this.route.navigate(['/resetPasswordFunction']);
  }
}
