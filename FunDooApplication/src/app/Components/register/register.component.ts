import { Component, OnInit } from '@angular/core';
import {  FormControl, Validators } from '@angular/forms';



@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  message ="";
  selected:"";
  hide=true;
  model: any;
  response: any;
  message1 ='';

  firstname= new FormControl('',[Validators.required]);
  lastname= new FormControl('',[Validators.required]);
  phonenum =new FormControl('',[Validators.required,Validators.maxLength(10), Validators.minLength(10)] );
  email =new FormControl('',[Validators.required ,Validators.email] );
  password =new FormControl('',[Validators.required ] );
  confirmpassword =new FormControl('',[Validators.required,  Validators.minLength(5) ] );
  constructor() {  } 


  ngOnInit() {
    }
register(){
  this.model={
  "firstName":this.firstname.value,
  "lastName":this.lastname.value,
  "phoneNumber": this.phonenum.value,
  "email":this.email.value,
  "password":this.password.value,
  // "confirm password":this.confirmpassword.value
}
if(this.firstname.value == '' || this.lastname.value == '' || this.phonenum.value =='' || this.email.value==''|| this.password.value=='')
{
  this.message ="Fields are missing";
}
else{
  this.message ="registered successfully"
  
}



}
}

