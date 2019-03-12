import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { LoginService } from 'src/app/Services/loginService/ServiceLogin';
import { Router } from '@angular/router';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss']
})
export class ResetPasswordComponent implements OnInit {

  constructor(private serviceReset: LoginService, private route: Router) { }
  model: any = {};
  public value = "";
  public session = "";
  response: any;
  password = new FormControl('', [Validators.required, Validators.minLength(8)]);

  confirmpassword = new FormControl('', [Validators.required, Validators.minLength(8)]);

  /**
   * @method ngOnInit()
   * @return void
   * @description Function to fetch data
   */
  ngOnInit() {
    let obs = this.serviceReset.getEmail();
    debugger;
    obs.subscribe((res: any) => {
      if(res.session == 'reset link has been expired')
      {
        this.route.navigate(['/session']);
      }
      else{
      this.value = res.key;
      this.session = res.session;
      }

    });
  }

  /**
   * @method resetPasswordFunction()
   * @return void
   * @description Function to reset the user password
   */
  resetPasswordFunction() {
    this.model = {

      "password": this.password.value
    }

    if (this.password.value == '' || this.confirmpassword.value == '') {

      alert("Fields are missing");

    } else if (this.password.value != this.confirmpassword.value) {

      alert("password and confirm password should be same");

    }
    else {
      debugger;
      let obj = this.serviceReset.UserResetData(this.model);
      debugger;
      obj.subscribe((res: any) => {
        if (res.message == "200") {
          alert("password reset is successfully, verify it");
          this.result();
        } else {
          alert("password reset is unsuccessfull, try once again clicking on forgot password");
          this.result();
        }
      });
    }

  }
  result() {
    this.route.navigate(['/login']);
  }
}
