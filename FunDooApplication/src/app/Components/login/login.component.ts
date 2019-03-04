import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  constructor() { }
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

  }
}
