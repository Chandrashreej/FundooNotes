import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatDialog } from '@angular/material';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import { FormControl } from '@angular/forms';
import * as moment from 'moment';
import { MoreoptionsService } from 'src/app/Services/moreoptions.service';

@Component({
  selector: 'app-editnotes',
  templateUrl: './editnotes.component.html',
  styleUrls: ['./editnotes.component.scss']
})
export class EditnotesComponent implements OnInit {

  id;
  model: any;
  TiTlE: any;
  description: any;
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  dateandtime: any;
  dateAndTimeCustom = new FormControl;
  color: any;
  notes: any;
  timer: boolean;
  dateshow: any;
  constructor(
    public dialogRef: MatDialogRef<EditnotesComponent>,
    public dialog: MatDialog,
    private notesService: DashboardService,
    private moreoptService: MoreoptionsService,
    @Inject(MAT_DIALOG_DATA) public data: any) {
    debugger
    this.TiTlE = this.data.notesdata.title;
    this.description = this.data.notesdata.takeANote;
    this.id = this.data.notesdata.id;
    this.color = this.data.notesdata.color;
    this.dateAndTime = this.data.notesdata.dateAndTime;
  }
  public dateAndTime: any;

  ngOnInit() {
  }

  close() {

    console.log(this.id);
    debugger;


    const email = localStorage.getItem('email');
    if (this.color == null || this.color == "undefined") {
      this.color = this.data.notesdata.color;
    }
    if (this.dateAndTime == null || this.dateAndTime == "undefined") {
      this.dateAndTime = this.data.notesdata.dateAndTime;
    }
    if (this.title.value == null || this.title.value == "undefined") {
      this.title.setValue(this.TiTlE);
    }
    if (this.takeANote.value == null || this.takeANote.value == "undefined") {
      this.takeANote.setValue(this.description);
    }
    this.model = {

      "title": this.title.value,
      "takeANote": this.takeANote.value,
      "email": email,
      "color": this.color,

    }

    let obs = this.notesService.usereNotesDialog(this.model, this.dateAndTime, this.id);

    obs.subscribe((res: any) => {
      if (res.message == "200") {
        this.dialogRef.close();
      }
    });

  }
  colourSetter(color) {
    this.color = color;
  }
  coloring(id, value) {
    debugger;

    let obs = this.moreoptService.coloringBackground(id, value);
    obs.subscribe((res: any) => {
      debugger;
      this.notes = res;

    });
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
    var currentDate = moment(this.fulldate).format("DD/MM/YYYY");
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

}