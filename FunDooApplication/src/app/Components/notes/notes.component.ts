import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import * as moment from 'moment';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.scss']
})
export class NotesComponent implements OnInit {
  flag: boolean = true;
  token1: any;
  notelist: any;
  constructor(private notesService: DashboardService) { }
  model: any = {};
  timer:any;
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  /**
 * var to hold present time
 */
  public currentDateAndTime = "";

  ngOnInit() {
    this.notesDisplaying();
    this.timer = false;
  }
  notesDisplaying() {

    const email = localStorage.getItem('email');
    let getnotes = this.notesService.fetchnotes(email);
    getnotes.subscribe((res: any) => {

      this.notelist = res as string[];

    });
  }

  reverseFlag() {
    this.flag = !this.flag;
  }


  fulldate: any;
  fulltime: any;
	/**
	 * functin for set reminder for today button
	 */
  today(id) {
    var day = new Date();
    this.timer = true;
    this.fulldate = day.toDateString();
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.currentDateAndTime = currentDate + " " + " 08:00 PM";

  }


  tomorrow(id) {
    debugger;
    var day = new Date();
    day.setDate(day.getDate() + 1);
    this.fulldate = day.toDateString();
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.currentDateAndTime = currentDate + " " + " 08:00 AM";
    this.timer = true;
  }

  nextWeek(id) {
    debugger;
    var day = new Date();

    this.fulldate = day.setDate(day.getDate() + ((1 + 7 - day.getDay()) % 7));
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.currentDateAndTime = currentDate + " " + " 08:00 AM";
    this.timer = true;
  }
  addNotes() {
    // debugger;
  
    const email = localStorage.getItem('email');
    this.model = {
      "title": this.title.value,
      "takeANote": this.takeANote.value,
      "email": email
    }


    // console.log(this.model);
    // debugger;
    let obs = this.notesService.usereNotes(this.model);
      //this.currentDateAndTime 
     
    // debugger;
    obs.subscribe((res: any) => {
      if (res.message == "200") {
        
        this.notesDisplaying();
        this.flag = true;
      }
    });
  }
  deleteNote(n) {
    let deleteObj = this.notesService.deleteNotesFunction(n.id);


    deleteObj.subscribe((res: any) => {
    
      if (res.message == "200") {
        this.notesDisplaying();
      }
      else {

      }
    });
  }
}
