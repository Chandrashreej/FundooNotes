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
    label.append("labelname",labelmodel.labelname);
    return this.http.post(this.serviceurl.host+this.serviceurl.setlabel,label);
  }

  deleteLabel(email,name){
    let label = new FormData();
    label.append("email",email);
    label.append("labelname",name);
    return this.http.post(this.serviceurl.host+this.serviceurl.deleteLabel,label);
  }
  updateingLabelName(email,updateLabelmodel,id ){
    let updLab= new FormData();
    updLab.append("email",email);
    updLab.append("newLabel", updateLabelmodel.updateLabel);
    updLab.append("labId",id);
    return this.http.post(this.serviceurl.host+this.serviceurl.updateLabel,updLab);

  }
  fetchLabel(email){
    debugger;
    let label = new FormData();
    label.append("email",email);
    return this.http.post(this.serviceurl.host+this.serviceurl.fetchlabel,label);
  }
  
  fetchLabeledNotes(email, labelname) {

    let userNotesdata = new FormData();
    userNotesdata.append("email", email);
    userNotesdata.append("labelname",labelname);
    return this.http.post(this.serviceurl.host + this.serviceurl.getAllLabeledNotes, userNotesdata);

  }
  fetchLabeledPinnedNotes(email, labelname) {

    let userNotesdata = new FormData();
    userNotesdata.append("email", email);
    userNotesdata.append("labelname",labelname);
    return this.http.post(this.serviceurl.host + this.serviceurl.getAllLabeledPinnedNotes, userNotesdata);

  }
}
