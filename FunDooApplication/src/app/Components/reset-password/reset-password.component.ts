import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {

  constructor() { }
  model: any = {};

  response: any;
  password = new FormControl('', [Validators.required, Validators.minLength(8)]);

  confirmpassword = new FormControl('', [Validators.required, Validators.minLength(8)]);
  ngOnInit() {
  }

  resetPasswordFunction(){
    this.model = {
      "password": this.password.value,

      "confirmpassword": this.confirmpassword.value
    }
    if ( this.password.value == '' || this.confirmpassword.value == '') {
     
      alert("Fields are missing");

    }else if (this.password.value != this.confirmpassword.value) {

      alert("password and confirm password should be same");

    }
  }

}
