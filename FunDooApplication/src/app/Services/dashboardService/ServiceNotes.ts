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
    tokenPayload:any;
    token:any;
    usereNotes(note:NotesModel,currentDateAndTime ){
      let userNotesdata = new FormData();

      // let headers_object = new HttpHeaders().set("Authorization",localStorage.getItem("token"));
      
      userNotesdata.append("title", note.title);
      userNotesdata.append("takeANote", note.takeANote);
      userNotesdata.append("email",note.email);
      userNotesdata.append("dateAndTime",currentDateAndTime );

      // headers_object.append("token",localStorage.getItem("token"));
      // debugger;
      // console.log(headers_object.get("Authorization"));
      // console.log(headers_object);
      // userNotesdata.append("time",time);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.setNotes), userNotesdata,
      //  { headers: headers_object }
      );
    }

    fetchnotes(email){
      
      let userNotesdata = new FormData();
      userNotesdata.append("email",email);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.getAllNotes), userNotesdata
            // { headers: headers_object }
      );
    }
    deleteNotesFunction (n){
      let id = new FormData();
      id.append('id',n);
      return this.http.post((this.sevriceurl.host+this.sevriceurl.deleteNote), id);
    }

}
