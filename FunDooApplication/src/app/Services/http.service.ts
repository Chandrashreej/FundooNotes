import { Injectable } from '@angular/core';
import { HttpClient } from 'selenium-webdriver/http';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
  baseUrl: string ;

  constructor(private Http:HttpClient) { 

  }


}
