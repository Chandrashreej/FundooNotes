import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';

import { Router } from '@angular/router';
import { RegisterService } from '../../Services/registerService/ServiceRegister'



@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {


  model: any = {};

  response: any;

  firstname = new FormControl('', [Validators.required, Validators.pattern('[a-zA-Z]*')]);

  lastname = new FormControl('', [Validators.required, Validators.pattern('[a-zA-Z]*')]);

  phonenum = new FormControl('', [Validators.required, , Validators.pattern('[0-9]*'), Validators.maxLength(10), Validators.minLength(10)]);

  email = new FormControl('', [Validators.required, Validators.email]);

  password = new FormControl('', [Validators.required, Validators.minLength(8)]);

  confirmpassword = new FormControl('', [Validators.required, Validators.minLength(8)]);


  constructor(private regService: RegisterService, private route: Router) { }

  ngOnInit() {
  }
	/**
	 * @method register()
	 * @return void
	 * @description Function to error validation
	 */
  register() {

    this.model = {

      "firstname": this.firstname.value,

      "lastname": this.lastname.value,

      "phonenum": this.phonenum.value,

      "email": this.email.value,

      "password": this.password.value,

      "confirmpassword": this.confirmpassword.value
    }

    if (this.firstname.value == '' || this.lastname.value == '' || this.phonenum.value == '' || this.email.value == '' || this.password.value == '' || this.confirmpassword.value == '') {

      alert("Fields are missing");

    }
    else if (this.password.value != this.confirmpassword.value) {

      alert("password and confirm password should be same");

    }
    else {

      debugger;

      console.log(this.model);

      let obj = this.regService.userRegister(this.model);

      debugger;

      obj.subscribe((res: any) => {

        console.log(res.message);

        if (res.message == "200") {

          alert("Successfully registered and verify your email!!!");
          this.route.navigate(['/login']);

        }
        else if (res.message == "204") {

          alert("Registration failed");

        } else if (res.message == "201") {

          alert("email already exist");

        } else if (res.message == "203") {

          alert("mobile number already exist");

        }
      });
    }

  }


}

