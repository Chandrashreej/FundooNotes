import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ServiceUrlService } from '../ServiceUrl/service-url.service';
import { ReminderModel } from '../Models/ReminderModel';

@Injectable({
  providedIn: 'root'
})
export class ReminderService {
  constructor(private http: HttpClient,
    private sevriceurl: ServiceUrlService) { }
    
    userReminder(reminder:ReminderModel,dateAndTime){
      let userReminderdata = new FormData();
      userReminderdata.append("title", reminder.title);
      userReminderdata.append("takeANote", reminder.takeANote);
      userReminderdata.append("email",reminder.email);
      userReminderdata.append("dateAndTime",dateAndTime);
      userReminderdata.append("color",reminder.color);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.setReminderNotes), userReminderdata);
    }

    fetchReminder(email){
      let userReminderdata = new FormData();
      userReminderdata.append("email",email);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.getAllReminderNotes), userReminderdata);
    }
    deleteReminderFunction (n){
      debugger;
      let id = new FormData();
      id.append('id',n);
      return this.http.post((this.sevriceurl.host+this.sevriceurl.deleteReminder), id);

    }
    coloringBackground(n,value,flag){
      debugger;
      let id = new FormData();
      id.append('id',n);
      id.append('value',value);
      id.append('flag',flag);
      return this.http.post((this.sevriceurl.host+this.sevriceurl.moreoptions), id);
  
  
    }
    
}
