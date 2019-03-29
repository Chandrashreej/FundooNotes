import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';

import { ReminderService } from 'src/app/Services/reminder.service';
import * as moment from 'moment';
import { ListService } from 'src/app/Services/list.service';
import { MoreoptionsService } from 'src/app/Services/moreoptions.service';
import { EditnotesComponent } from '../editnotes/editnotes.component';
import { DomSanitizer } from '@angular/platform-browser';
import { MatIconRegistry, MatDialog, MatSnackBar, MatDialogConfig } from '@angular/material';
@Component({
  selector: 'app-reminder',
  templateUrl: './reminder.component.html',
  styleUrls: ['./reminder.component.scss']
})
export class ReminderComponent implements OnInit {
  flag: boolean = true;
  token1: any;
  notelist: any;
  classcard;
  backgroundColour: any;
  notes: any;

  constructor(private moreoptService: MoreoptionsService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,
    private snackBar: MatSnackBar
    , private reminderService: ReminderService, private listview: ListService) {


    this.listview.getView().subscribe((res => {
      this.view = res;
      this.direction = this.view.data;
      this.classcard = this.view.class;
      console.log("Direction is :", this.direction);

      this.layout = this.direction + " " + this.wrap;
      console.log("Layout is ", this.layout);
      console.log("class is ", this.classcard);
    }))

  }
  model: any = {};
  public dateAndTime = "";
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  fulldate: any;
  fulltime: any;
  view;
  dateandtime: any;
  wrap: string = "wrap";
  direction: string = "row";
  dateChooser = new FormControl();
  // [formControl]="dateChooser"
  layout: string = this.direction + " " + this.wrap;
  timer: any;
  ngOnInit() {

    this.displayReminder();
    this.timer = false;
    this.listview.getView().subscribe((res => {
      this.view = res;
      this.direction = this.view.data;
      this.layout = this.direction + " " + this.wrap;
    }))

  }
  timeChooser(str) {
debugger;
var chooser = moment(this.dateChooser.value).format("DD/MM/YYYY");
    if (str == "Morning") {
      this.dateAndTime = chooser+ " " + " 08:00 AM ";
    }
    else if (str == "Afternoon")
    {
      this.dateAndTime = chooser + " " + " 1:00 PM ";
    }
    else if (str == "Evening")
    {
      this.dateAndTime = chooser + " " + " 6:00 PM ";
    }
    else if (str == "Night")
    {
      this.dateAndTime = chooser+ " " + " 8:00 PM ";
    }
  }
  openDialog(n): void {

    debugger
    const dialogconfg = new MatDialogConfig();

    dialogconfg.autoFocus = true;
    dialogconfg.width = "600px"
    dialogconfg.height = "200px"
    dialogconfg.panelClass = 'custom-dialog-container'
    debugger;
    dialogconfg.data = {

      notesdata: n

    }
    const open = this.dialog.open(EditnotesComponent, dialogconfg);

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
  colourSetter(color) {
    this.backgroundColour = color;
  }
  coloring(id, value) {
    debugger;
    let obs = this.moreoptService.coloringBackgroundinReminder(id, value);
    obs.subscribe((res: any) => {
      debugger;
      this.notes = res;
      this.displayReminder();
      // obs.unsubscribe();
    });
  }
  openSnackBar(message: string, action: string) {
    this.snackBar.open(message, action, {
      duration: 2000,
    });
  }
  today(id) {
    var day = new Date();
    this.fulldate = day.toDateString();
    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");
    this.dateAndTime = currentDate + " " + " 08:00 PM";
    this.timer = true;
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
  reverseFlag() {
    this.flag = !this.flag;
  }
  reminder() {
    debugger;
    if (this.title.value == null && this.takeANote.value == null && this.dateAndTime == undefined) {
      this.flag = true;
    }
    else if (this.dateAndTime == undefined) {
      this.flag = true;
    }
    else {
      debugger;
      const email = localStorage.getItem('email');
      debugger;
      this.model = {
        "title": this.title.value,
        "takeANote": this.takeANote.value,
        "email": email,
        "color": this.backgroundColour
      }

      console.log(this.model);
      debugger;
      let obs = this.reminderService.userReminder(this.model, this.dateAndTime);
      debugger;
      obs.subscribe((res: any) => {
        if (res.message == "200") {
          this.flag = true;
          this.displayReminder();
        }
      });
    }
  }


  deleteReminder(n) {
    debugger;
    let deleteObj = this.reminderService.deleteReminderFunction(n.id);


    deleteObj.subscribe((res: any) => {
      console.log(res.message);
      if (res.message == "200") {
        this.displayReminder();
      }
      else {

      }
    });
  }

}
