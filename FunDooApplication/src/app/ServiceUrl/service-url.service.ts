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
  public getAllLabeledNotes = 'codeigniter/getAllLabeledNotes';

  public getAllLabeledPinnedNotes = 'codeigniter/getAllLabeledPinnedNotes';

  public getAllPinnedNotes = 'codeigniter/getAllPinnedNotes';

  public getNameValue = 'codeigniter/getNameValue';
   
  public setNotes = 'codeigniter/setNotes';
  public setNotesDialog = 'codeigniter/setNotesDialog';
  public setReminderDialog = 'codeigniter/setReminderDialog';

  public setReminderNotes = 'codeigniter/setReminderNotes';
  public getAllReminderNotes = 'codeigniter/getAllReminderNotes';
  public deleteNote = 'codeigniter/deleteNote';
  public deleteReminder = 'codeigniter/deleteReminder';
  public moreoptions = 'codeigniter/moreoptions';
  public coloringBackgroundForReminder = 'codeigniter/coloringBackgroundForReminder';
  public fetchArch = "codeigniter/fetcharchive";
  public unarchived = "codeigniter/unarchive";
  public fetchTrash = "codeigniter/fetchTrash";
  public unTrash = "codeigniter/unTrash";

  public setlabel = "codeigniter/setlabel";

  public deleteLabel= "codeigniter/deleteLabel";
  public updateLabel= "codeigniter/updateLabel";

  public fetchlabel = "codeigniter/fetchlabel";
  public socialLoginData = "codeigniter/socialLoginData";

  public imageFetcher = "codeigniter/imageFetcher";

  public imageSetter = "codeigniter/imageSetter";
  public dragNDrop = "codeigniter/dragNDrop";



  public setlabeleledNotes = 'codeigniter/setlabeleledNotes';

  
}
