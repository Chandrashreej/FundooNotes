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
  public reset ='codeigniter/resetPassword';
  public getEmail = 'codeigniter/getEmailId';
  public getAllNotes = 'codeigniter/getAllNotes';
  public getNameValue = 'codeigniter/getNameValue';
   
  public setNotes = 'codeigniter/setNotes';
  public setNotesDialog = 'codeigniter/setNotesDialog';
  public setReminderDialog = 'codeigniter/setReminderDialog';

  public setReminderNotes = 'codeigniter/setReminderNotes';
  public getAllReminderNotes = 'codeigniter/getAllReminderNotes';
  public deleteNote = 'codeigniter/deleteNote';
  public deleteReminder = 'codeigniter/deleteReminder';
  public coloringBackground = 'codeigniter/coloringBackgroundFunction';
  public coloringBackgroundForReminder = 'codeigniter/coloringBackgroundForReminder';
  
}
