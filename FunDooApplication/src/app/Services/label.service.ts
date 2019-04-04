import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ServiceUrlService } from '../ServiceUrl/service-url.service';

@Injectable({
  providedIn: 'root'
})
export class LabelService {
  constructor(private http :HttpClient,private serviceurl:ServiceUrlService) { }


  setLabel(email,labelmodel){
    let label = new FormData();
    label.append("email",email);
    label.append("labelmodel",labelmodel.labelname);
    return this.http.post(this.serviceurl.host+this.serviceurl.setlabel,label);
  }

  fetchLabel(email){
    let label = new FormData();
    label.append("email",email);
    return this.http.post(this.serviceurl.host+this.serviceurl.fetchlabel,label);
  }
}
