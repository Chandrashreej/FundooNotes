import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ServiceUrlService {

  constructor() { }
      
  registerUrl: 'signup';
  loginUrl:'signin';
}
