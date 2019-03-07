import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ServiceUrlService {

  constructor() { }
   public host = environment.baseUrl;
  public registerUrl= 'codeigniter/signup';
  public loginUrl='codeigniter/signin';
  public forgot ='codeigniter/forgotPassword';
}
