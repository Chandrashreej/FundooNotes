import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.scss']
})
export class NotesComponent implements OnInit {
flag: boolean =true;
  token1: any;
  notelist: any;
  constructor(private notesService: DashboardService) { }
model:any={};

title = new FormControl();
displayTitle: any;
displayTakeANote: any; 
takeANote = new FormControl();
  
ngOnInit() {
  const email =localStorage.getItem('email');
let getnotes =this.notesService.fetchnotes(email);
getnotes.subscribe((res:any)=>{
this.notelist = res as string[];


  // this.displayTitle = res.title;
  // this.displayTakeANote =res.takeANote;
});
  }
  
  reverseFlag(){
    this.flag = !this.flag;
  }
  notes(){
    debugger;
    const email =localStorage.getItem('email');
    this.model={
      "title": this.title.value,
      "takeANote": this.takeANote.value,
      "email":email
    }

    console.log(this.model);
    debugger;
    let obs= this.notesService.usereNotes(this.model);
    debugger;
    obs.subscribe((res: any) => {
      if(res.message == "200")
      {
        this.token1=res.token;
      }
   });
  }
}
