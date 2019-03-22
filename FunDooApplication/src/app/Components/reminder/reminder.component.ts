import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';

import { ReminderService } from 'src/app/Services/reminder.service';
import * as moment from 'moment';
@Component({
  selector: 'app-reminder',
  templateUrl: './reminder.component.html',
  styleUrls: ['./reminder.component.scss']
})
export class ReminderComponent implements OnInit {
  flag: boolean = true;
  token1: any;
  notelist: any;
  constructor(private reminderService: ReminderService) { }
  model: any = {};
  public currentDateAndTime = "";
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  fulldate: any;
  fulltime: any;
  ngOnInit() {

    this.displayReminder();

  }
  displayReminder() {
    debugger;
    const email = localStorage.getItem('email');
    let getnotes = this.reminderService.fetchReminder(email);
    debugger;
    getnotes.subscribe((res: any) => {
      this.notelist = res as string[];
    });
  }
  today(id) {
    var day = new Date();
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

  }

  nextWeek(id) {
    debugger;
    var day = new Date();

    this.fulldate = day.setDate(day.getDate() + ((1 + 7 - day.getDay()) % 7));
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.currentDateAndTime = currentDate + " " + " 08:00 AM";

  }
  reverseFlag() {
    this.flag = !this.flag;
  }
  reminder() {
    debugger;
    const email = localStorage.getItem('email');
    this.model = {
      "title": this.title.value,
      "takeANote": this.takeANote.value,
      "email": email
    }

    console.log(this.model);
    debugger;
    let obs = this.reminderService.userReminder(this.model);
    debugger;
    obs.subscribe((res: any) => {
      if (res.message == "200") {
        this.flag = true;
        this.displayReminder();
      }
    });
  }


  deleteReminder(n) {
    let deleteObj = this.reminderService.deleteReminderFunction(n.id);


    deleteObj.subscribe((res: any) => {
      console.log(res.message);
      if (res.message == "200") {

      }
      else {

      }
    });
  }

}
