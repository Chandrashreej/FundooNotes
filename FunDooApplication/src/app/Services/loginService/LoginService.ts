import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LoginModel } from '../../Models/login.model';
@Injectable({
    providedIn: 'root'
})
export class LoginService {
    constructor(private http: HttpClient) { }
    apiURL: string = 'http://localhost/codeigniter/signin';
    userLogin(log: LoginModel) {
        let userLogindata = new FormData();
        userLogindata.append("email", log.email);
        userLogindata.append("email", log.password);
        return this.http.post(this.apiURL, userLogindata);
    }
}
