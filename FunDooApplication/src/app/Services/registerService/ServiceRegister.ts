import { Injectable } from '@angular/core';
import { RegisterModel } from '../../Models/register.model';
import { HttpClient } from '@angular/common/http';



@Injectable({
  providedIn: 'root'
})
export class RegisterService {
  constructor(private http: HttpClient ) { }
 apiUrl: "http://localhost/codeigniter/signup";

  userRegister(reg: RegisterModel) {
    
    let userRegister = new FormData();
    userRegister.append("firstname", reg.firstname);
    userRegister.append("lastname", reg.lastname);
    userRegister.append("email", reg.email);
    userRegister.append("phonenum", reg.phonenum);

    userRegister.append("email", reg.email);

    userRegister.append("password", reg.password);


    return this.http.post(this.apiUrl, userRegister);
  }
 // (this.sevriceurl.host + this.sevriceurl.registerUrl)
 //,private sevriceurl:serviceUrl 
 //import { serviceUrl } from 'src/app/ServiceUrl/serviceUrl';
}
