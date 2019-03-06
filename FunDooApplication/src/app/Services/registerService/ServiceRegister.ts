import { Injectable } from '@angular/core';
import { RegisterModel } from '../../Models/register.model';
import { HttpClient } from '@angular/common/http';

import { environment } from 'src/environments/environment';
import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';



@Injectable({
  providedIn: 'root'
})
export class RegisterService {
  constructor(private http: HttpClient,private sevriceurl:ServiceUrlService  ) { }
// baseUrl= "http://localhost/codeigniter/signup";



  userRegister(reg: RegisterModel) {
    debugger;
    let userRegister = new FormData();
    userRegister.append("firstname", reg.firstname);
    userRegister.append("lastname", reg.lastname);
    userRegister.append("email", reg.email);
    userRegister.append("phonenum", reg.phonenum);

    userRegister.append("email", reg.email);

    userRegister.append("password", reg.password);

debugger;
    return this.http.post(environment.baseUrl + this.sevriceurl.registerUrl, userRegister);
  }


}
