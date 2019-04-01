import { Injectable } from '@angular/core';

import { ServiceUrlService } from '../ServiceUrl/service-url.service';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ArchiveService {

  constructor(private http:HttpClient,private serviceurl:ServiceUrlService) { }

  fetchArchive(email){
    let fetarc = new FormData();
    fetarc.append("email",email);
    return this.http.post(this.serviceurl.host+this.serviceurl.fetchArch,fetarc);
  }

  unarchived(id,flag){
    let unarch = new FormData();
    unarch.append("uid",id);
    return this.http.post(this.serviceurl.host+this.serviceurl.unarchived,unarch);
  }
}
