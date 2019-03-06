import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LoginModel } from '../../Models/login.model';

import { environment } from 'src/environments/environment';
import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';

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
        return this.http.post((environment.baseUrl + this.sevriceurl.loginUrl), userLogindata);
    }
}
