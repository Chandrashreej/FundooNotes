import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { LoginService } from "src/app/Services/loginService/LoginService";
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  constructor(private logService: LoginService) { }
  message = "";
  selected: "";
  hide = true;
  model: any;
  response: any;
  message1 = '';


  isCollapsed: boolean = true;

  email = new FormControl('', [Validators.required, Validators.email]);
  password = new FormControl('', [Validators.required]);

  toggleCollapse() {

    this.isCollapsed = !this.isCollapsed;
  }

  ngOnInit() {
  }

  login() {
    this.model = {
      "email": this.email.value,
      "password": this.password.value,
      
    }
    if (this.email.value == '' || this.password.value == '') {
      this.message = "Fields are missing";
    }
    else {
      this.message = "logged in successfully"

    }
    console.log(this.model);
    let obj = this.logService.userLogin(this.model);

    obj.subscribe((res: any) => {
      console.log(res.message);
      if (res.message == "200") {
       alert("logged is succesfull ");
      } else if (res.message == "204") {
        alert( "enter valid data");
      }
    });
  }
}
