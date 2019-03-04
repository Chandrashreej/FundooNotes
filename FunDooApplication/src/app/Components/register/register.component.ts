import { Component, OnInit } from '@angular/core';
import { FormControl, Validators, FormGroup } from '@angular/forms';

import { Router } from '@angular/router';
import{RegisterService} from '../../Services/register.service'



@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  message = "";
  selected: "";

  model: any ={};
  response: any;

  regForm:FormGroup;
  submitted =false;
  
  firstname = new FormControl('', [Validators.required, Validators.pattern('[a-zA-Z]*')]);
  lastname = new FormControl('', [Validators.required, Validators.pattern('[a-zA-Z]*')]);
  phonenum = new FormControl('', [Validators.required,,Validators.pattern('[0-9]*'), Validators.maxLength(10), Validators.minLength(10)]);
  email = new FormControl('', [Validators.required, Validators.email]);
  password = new FormControl('', [Validators.required, Validators.minLength(5)]);
  confirmpassword = new FormControl('', [Validators.required, Validators.minLength(5)]);

  constructor(private regService:RegisterService, private router:Router) { }


  ngOnInit() {
  }

  register() {
    debugger;
    this.model = {
      "firstName": this.firstname.value,
      "lastName": this.lastname.value,
      "phoneNumber": this.phonenum.value,
      "email": this.email.value,
      "password": this.password.value,
      "confirmpassword": this.confirmpassword.value
    }
    if (this.firstname.value == '' || this.lastname.value == '' || this.phonenum.value == '' || this.email.value == '' || this.password.value == '' || this.confirmpassword.value == '') {
      this.message = "Fields are missing";
    }
    else if(this.password.value != this.confirmpassword.value)
    {
        this.message ="password and confirm password should be same ";
    }
    else {
      this.message = "registered successfully";
     
    }
    alert('Something is about to display');
    console.log(this.model);
    let obj = this.regService.userRegister(this.model).subscribe(data=>{console.log(data),error=>console.log(data)});;


  }

  
  // submitForm(value:any)
  // {
  //   this.submitted =true;
  //   console.log(this.model);
  //   alert('Success'+JSON.stringify(value))
  //   if(this.regForm.invalid)
  //   {
  //     return;
  //   }
  // }


}

