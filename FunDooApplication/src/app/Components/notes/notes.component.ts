import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import * as moment from 'moment';
import { ListService } from 'src/app/Services/list.service';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.scss']
})
export class NotesComponent implements OnInit {
  flag: boolean = true;
  token1: any;
  notelist: any;
  constructor(private notesService: DashboardService, private listview: ListService) { }
  model: any = {};
  timer:any;
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  dateandtime :any;

  wrap: string = "wrap";
  direction: string = "row";

	layout: string = this.direction + " " + this.wrap;
  /**
 * var to hold present time
 */
  public dateAndTime = "";
  view;
  ngOnInit() {
    this.notesDisplaying();
    this.timer = false;

    this.listview.getView().subscribe((res=>{
      this.view = res;
      this.direction = this.view.data;
      this.layout = this.direction + " "+this.wrap;
  }))
  }
  notesDisplaying() {

    const email = localStorage.getItem('email');
    let getnotes = this.notesService.fetchnotes(email);
    getnotes.subscribe((res: any) => {

      this.notelist = res as string[];
      this.displayTitle =this.notelist.title;
      this.displayTakeANote = this.notelist.takeANote;
      this.dateAndTime
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
    this.dateAndTime = currentDate + " " + " 08:00 PM";

  }


  tomorrow(id) {
    debugger;
    var day = new Date();
    day.setDate(day.getDate() + 1);
    this.fulldate = day.toDateString();
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.dateAndTime = currentDate + " " + " 08:00 AM";
    this.timer = true;
  }

  nextWeek(id) {
    debugger;
    var day = new Date();

    this.fulldate = day.setDate(day.getDate() + ((1 + 7 - day.getDay()) % 7));
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.dateAndTime = currentDate + " " + " 08:00 AM";
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
    let obs = this.notesService.usereNotes(this.model,this.dateAndTime);
      //this.dateAndTime 
     
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
