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
		private sevriceurl: ServiceUrlService,
		private route: ActivatedRoute) { }
	//apiURL: string = 'http://localhost/codeigniter/signin';

	/**
	 * @method userLogin()
	 * @return observable data
	 * @param login
	 * @description Function to send login data to server
	 */
	userLogin(log: LoginModel) {
		let userLogindata = new FormData();
		userLogindata.append("email", log.email);
		userLogindata.append("password", log.password);
		return this.http.post((this.sevriceurl.host + this.sevriceurl.loginUrl), userLogindata);
	}
	/**
	 * @method userForgotPasswordData()
	 * @return observable data
	 * @param forgot
	 * @description Function to send forgot to server
	 */
	userForgotPasswordData(forgot: ForgotPasswordModel) {
		debugger;
		let userData = new FormData();
		userData.append("email", forgot.email);
		return this.http.post(this.sevriceurl.host + this.sevriceurl.forgot, userData);
	}

	/**
	 * @method UserResetData()
	 * @return observable data
	 * @param reset
	 * @description Function to send reset data to server
	 */

	UserResetData(reset: ResetModel) {
		debugger;
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
	/**
	 * @method getEmail()
	 * @return observable data
	 * @param reset
	 * @description Function to send get email from server
	 */
	getEmail() {
		debugger;
		let urlTocken = new FormData();
		urlTocken.append("token", this.route.snapshot.queryParamMap.get("token"));
		return this.http.post(
			this.sevriceurl.host + this.sevriceurl.getEmail,
			urlTocken
		);
	}
	// getNotes() {
	// 	debugger;
	// 	let notes = new FormData();
	// 	notes.append("token", this.route.snapshot.queryParamMap.get("token"));
	// 	return this.http.post(
	// 		this.sevriceurl.host + this.sevriceurl.getNotes,
	// 		notes
	// 	);
	// }
	userNotes(){
		
	}
		/**
	 * @method socialLoginData()
	 * @return observable data
	 * @param login
	 * @description Function to send login data to server
	 */
	socialLogin(email, name, pltForm) {
		let socialLoginData = new FormData();
		socialLoginData.append("email", email);
		socialLoginData.append("firstname", name);
		socialLoginData.append("pltForm", pltForm);
		return this.http.post(
			this.sevriceurl.host + this.sevriceurl.socialLoginData,
			socialLoginData
		);
	}
}
