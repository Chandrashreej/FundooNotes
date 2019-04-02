import { Injectable } from '@angular/core';

import { ServiceUrlService } from '../ServiceUrl/service-url.service';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TrashService {

 
  constructor(private http:HttpClient,private serviceurl:ServiceUrlService) { }

  fetchTrash(email){
    let fetTrash = new FormData();
    fetTrash.append("email",email);
    return this.http.post(this.serviceurl.host+this.serviceurl.fetchTrash,fetTrash);
  }

  untrash(id,flag){
    let unTrs = new FormData();
    unTrs.append("uid",id);
    unTrs.append("flag",flag);
    return this.http.post(this.serviceurl.host+this.serviceurl.unTrash,unTrs);
  }
  deleteNotesFunction (n){
    let id = new FormData();
    id.append('id',n);
    return this.http.post(this.serviceurl.host+this.serviceurl.deleteNote, id);
  }

}
