import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';
import { NotesModel } from 'src/app/Models/Notes.model';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {
  constructor(private http: HttpClient,
    private sevriceurl: ServiceUrlService) { }
  tokenPayload: any;
  token: any;
  usereNotes(note: NotesModel, currentDateAndTime) {
    let userNotesdata = new FormData();

    userNotesdata.append("color", note.color)
    userNotesdata.append("title", note.title);
    userNotesdata.append("takeANote", note.takeANote);
    userNotesdata.append("email", note.email);
    userNotesdata.append("dateAndTime", currentDateAndTime);
    userNotesdata.append("image",note.image);
    userNotesdata.append("pinned",note.pinned);

    return this.http.post((this.sevriceurl.host + this.sevriceurl.setNotes), userNotesdata,
    );
  }
  usereNotesDialog(note: NotesModel, currentDateAndTime, n) {
    let userNotesdata = new FormData();

    // let headers_object = new HttpHeaders().set("Authorization",localStorage.getItem("token"));
    userNotesdata.append("color", note.color)
    userNotesdata.append("title", note.title);
    userNotesdata.append("takeANote", note.takeANote);
    userNotesdata.append("email", note.email);
    userNotesdata.append("dateAndTime", currentDateAndTime);
    userNotesdata.append("id", n);

    // headers_object.append("token",localStorage.getItem("token"));
    // debugger;
    // console.log(headers_object.get("Authorization"));
    // console.log(headers_object);
    // userNotesdata.append("time",time);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.setNotesDialog), userNotesdata,
      //  { headers: headers_object }
    );
  }

  fectImageService(email) {
    debugger;
    let userImage = new FormData();
    userImage.append("email", email);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.imageFetcher), userImage);

  }
  setImageService(email, value) {

    let userImage = new FormData();
    userImage.append("email", email);
    userImage.append("value", value)
    return this.http.post((this.sevriceurl.host + this.sevriceurl.imageSetter), userImage);

  }
  getname(email) {
    debugger;
    let nameValue = new FormData();
    nameValue.append('email', email);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.getNameValue), nameValue);

  }
  fetchnotes(email) {

    let userNotesdata = new FormData();
    userNotesdata.append("email", email);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.getAllNotes), userNotesdata);

  }

  fetchPinnedNotes(email) {
    let userNotesdata = new FormData();
    userNotesdata.append("email", email);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.getAllPinnedNotes), userNotesdata);

  }



  deleteNotesFunction(n) {

    let id = new FormData();
    id.append('id', n);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.deleteNote), id);

  }
  coloringBackground(n, value, flag) {

    let id = new FormData();
    id.append('id', n);
    id.append('value', value);
    id.append('flag', flag);
    return this.http.post((this.sevriceurl.host + this.sevriceurl.coloringBackground), id);

  }

}
