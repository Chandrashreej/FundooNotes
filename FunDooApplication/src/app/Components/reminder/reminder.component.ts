import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';

@Component({
  selector: 'app-reminder',
  templateUrl: './reminder.component.html',
  styleUrls: ['./reminder.component.scss']
})
export class ReminderComponent implements OnInit {
  flag: boolean =true;
  token1: any;
  constructor(private notesService: DashboardService) { }
model:any={};

title = new FormControl();

  
takeANote = new FormControl();
  
ngOnInit() {

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
