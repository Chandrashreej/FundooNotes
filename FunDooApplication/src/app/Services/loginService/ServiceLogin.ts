import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LoginModel } from '../../Models/login.model';

import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';
import { ForgotPasswordModel } from 'src/app/Models/forgotPassword.model';

@Injectable({
    providedIn: 'root'
})
export class LoginService {
    constructor(private http: HttpClient,private sevriceurl:ServiceUrlService ) { }
    //apiURL: string = 'http://localhost/codeigniter/signin';
    
    userLogin(log: LoginModel) {
        let userLogindata = new FormData();
        userLogindata.append("email", log.email);
        userLogindata.append("password", log.password);
        return this.http.post((this.sevriceurl.host + this.sevriceurl.loginUrl), userLogindata);
    }

    userForgotPasswordData(forgot:ForgotPasswordModel ) {
		let userData = new FormData();
		userData.append("email", forgot.email);
		return this.http.post(this.sevriceurl.host + this.sevriceurl.forgot,userData);
	}
}
