import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LoginModel } from '../../Models/login.model';

import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';
import { ForgotPasswordModel } from 'src/app/Models/forgotPassword.model';

import { ActivatedRoute } from '@angular/router';
import { ResetModel } from 'src/app/Models/reset.model';

@Injectable({
    providedIn: 'root'
})
export class LoginService {
    constructor(private http: HttpClient,
        private sevriceurl:ServiceUrlService,
        private route: ActivatedRoute ) { }
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
    UserResetData(reset:ResetModel){
		let userResetData = new FormData();
		userResetData.append(
			"token",
			this.route.snapshot.queryParamMap.get("token")
		);
		userResetData.append("password", reset.password);
		return this.http.post(
			this.sevriceurl.host + this.sevriceurl.reset,
			userResetData
        );
        }

    getEmail() {
		let urlTocken = new FormData();
		urlTocken.append("token", this.route.snapshot.queryParamMap.get("token"));
		return this.http.post(
			this.sevriceurl.host + this.sevriceurl.getEmail,
			urlTocken
		);
	}
    
}
