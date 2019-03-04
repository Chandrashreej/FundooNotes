import { Injectable } from '@angular/core';
import { RegisterModel } from '../Models/register.model';
import {HttpClient} from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class RegisterService {
  constructor(private http: HttpClient) { }

  apiURL: string = 'http://localhost/codeigniter/signup';
  
  userRegister(reg:RegisterModel)
  {
  let userRegister = new FormData();
  userRegister.append("firstname",reg.firstname);
  userRegister.append("lastname",reg.lastname);
  userRegister.append("username",reg.username);
  
  userRegister.append("email",reg.email);
  
  userRegister.append("password1",reg.password1);
  
  userRegister.append("password2",reg.password2);
  
  return this.http.post(this.apiURL,userRegister);
  }
}
