import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ServiceUrlService } from 'src/app/ServiceUrl/service-url.service';
import { NotesModel } from 'src/app/Models/Notes.model';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {
constructor(private http: HttpClient,
    private sevriceurl: ServiceUrlService) { }
    
    usereNotes(note:NotesModel){
      let userNotesdata = new FormData();
      userNotesdata.append("title", note.title);
      userNotesdata.append("takeANote", note.takeANote);
      userNotesdata.append("email",note.email);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.setNotes), userNotesdata);
    }

    fetchnotes(email){
      let userNotesdata = new FormData();
      userNotesdata.append("email",email);
      return this.http.post((this.sevriceurl.host + this.sevriceurl.getAllNotes), userNotesdata);
    }
    
}
