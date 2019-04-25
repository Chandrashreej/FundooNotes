import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import * as moment from 'moment';
import { ListService } from 'src/app/Services/list.service';
import { MatDialog, MatIconRegistry, MatSnackBar, MatDialogConfig, MatSnackBarConfig } from '@angular/material';
import { DomSanitizer } from '@angular/platform-browser';
import { EditnotesComponent } from '../editnotes/editnotes.component';
import { NotesModel } from 'src/app/Models/Notes.model';

import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { LabelService } from 'src/app/Services/label.service';
@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.scss']
})

export class NotesComponent implements OnInit {

  model: any = {};
  notesarray: NotesModel[] = [];

  flag: boolean = true;

  notelist: any;
  classcard;
  notes: any;
  backgroundColour: any;
  timer: any;
  labelb: boolean = false;
  displayTitle: any;
  displayTakeANote: any;
  dateandtime: any;
  fulldate: any;
  fulltime: any;
  dateAndTime: any;
  view: any;

  title = new FormControl();
  takeANote = new FormControl();
  dateAndTimeCustom = new FormControl();
  dateChooser = new FormControl();

  wrap: string = "wrap";
  direction: string = "row";
  layout: string = this.direction + " " + this.wrap;
  pinnedBool: boolean = false;

  constructor(private notesService: DashboardService,
    private listview: ListService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,
    private snackBar: MatSnackBar,
    private labelsev: LabelService, ) {

    this.listview.getView().subscribe((res => {

      this.view = res;

      this.direction = this.view.data;

      this.classcard = this.view.class;

      this.layout = this.direction + " " + this.wrap;

    }));
  }
  ngOnInit() {

    this.notesDisplaying();

    this.timer = false;

    this.labelb = false;

    this.listview.getView().subscribe((res => {

      this.view = res;

      this.direction = this.view.data;

      this.layout = this.direction + " " + this.wrap;

    }));
    this.fetchPinned();
    this.fetchLabel();

    // setInterval(() => {

    //   this.remaindme();

    // }, 1000);

  }

  fetchImage() {

    debugger;

    var email = localStorage.getItem("email");

    let fetchobs = this.notesService.fectImageService(email);


    fetchobs.subscribe((res: any) => {

      debugger

      this.mainimage = res;

    })

  }


  mainimage;
  imageid;


  selectedImage(event, id) {

    debugger;

    this.imageid = id;

    var files = event.target.files;

    var file = files[0];

    // if (files && file) {

      var reader = new FileReader();

      reader.onload = this._handleImageLoader.bind(this);

      reader.readAsBinaryString(file);

    // }
  }
  imageBoolForMainCrd: boolean = false;
  imageBoolForNotesCrd: boolean = false;
  base64textString
  imagepre
  present
  mainimagefornotes
  _handleImageLoader(readerEvt) {

    debugger;

    var binarstring = readerEvt.target.result;

    this.base64textString = btoa(binarstring);

    if (this.imageid != "01") {

      this.mainimagefornotes = "data:image/jpeg;base64," + this.base64textString;

      var flag = "image";
      this.notestools(this.imageid, this.mainimagefornotes, flag)

    }
    else {
      this.imageBoolForMainCrd = true;
      this.mainimage = "data:image/jpeg;base64," + this.base64textString;
    }

  }



  timeChooser(str, id) {

    debugger;
    var chooser = moment(this.dateChooser.value).format("DD/MM/YYYY");

    if (id = 1) {

      if (str == "Morning") {

        this.dateAndTime = chooser + " " + " 08:00 AM ";

      }
      else if (str == "Afternoon") {

        this.dateAndTime = chooser + " " + " 1:00 PM ";

      }
      else if (str == "Evening") {

        this.dateAndTime = chooser + " " + " 6:00 PM ";

      }
      else if (str == "Night") {

        this.dateAndTime = chooser + " " + " 8:00 PM ";

      }

      this.timer = true;
    }
    else{

      if (str == "Morning") {

        this.dateAndTime = chooser + " " + " 08:00 AM ";

      }
      else if (str == "Afternoon") {

        this.dateAndTime = chooser + " " + " 1:00 PM ";

      }
      else if (str == "Evening") {

        this.dateAndTime = chooser + " " + " 6:00 PM ";

      }
      else if (str == "Night") {

        this.dateAndTime = chooser + " " + " 8:00 PM ";

      }

      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }

  }

  duplicate
  DateAndTime
  remaindme() {

    debugger;
    var day = new Date();

    var fulldate = day.toDateString() + " " + (day.getHours() % 12) + ":" + day.getMinutes();

    fulldate = moment(fulldate).format("DD/MM/YYYY  hh:mm") + " PM";

    this.notelist.forEach(reminder => {
      debugger;
      console.log("reminder", reminder.dateAndTime);

      this.duplicate = reminder;


      this.DateAndTime = fulldate;

      console.log("rennnder", this.DateAndTime);

      // this.dateAndTime = DateAndTime;

      if (this.DateAndTime == this.duplicate.dateAndTime) {
        debugger;
        this.snackBar.open(reminder.title, ' ', { duration: 2000 });
        alert("their is reminder" + reminder.title);
      }
    });

  }


  today(id) {

    console.log(id);

    var day = new Date();

    this.timer = true;

    this.fulldate = day.toDateString();

    var currentDate = moment(this.fulldate).format("DD/MM/YYYY");

    this.dateAndTime = currentDate + " " + " 08:00 PM";

    if (id != '01') {
      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }

  }
  tomorrow(id) {

    var day = new Date();

    day.setDate(day.getDate() + 1);

    this.fulldate = day.toDateString();

    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");

    this.dateAndTime = currentDate + " " + " 08:00 AM";

    this.timer = true;

    if (id != '01') {
      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }
  }


  nextWeek(id) {

    var day = new Date();

    this.fulldate = day.setDate(day.getDate() + ((1 + 7 - day.getDay()) % 7));

    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");

    this.dateAndTime = currentDate + " " + " 08:00 AM";

    this.timer = true;

    if (id != '01') {
      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }

  }
  closedate() {

    this.timer = false;

    this.dateAndTime = "undefined";

  }
  closelabel() {

    this.labelb = false;

    this.notelabel = null;

  }

  imagerOfNotes
  notesDisplaying() {

    const email = localStorage.getItem('email');

    let getnotes = this.notesService.fetchnotes(email);

    getnotes.subscribe((res: any) => {

      console.log("res", res);
      debugger;
      this.notelist = res as string[];
      console.log("taki taki", this.notelist);

    });
  }
  colourSetter(color) {

    this.backgroundColour = color;

  }
  str;
  coloring(id, value) {


    debugger;

    this.str = "color";

    let obs = this.notesService.moreoptions(id, value, this.str);

    obs.subscribe((res: any) => {

      this.notes = res;

      // this.notesDisplaying();

    });

  }

  reverseFlag() {
    this.flag = !this.flag;
  }


  stringvalue;
  closedateforNotes(id) {

    this.timer = false;

    this.dateAndTime = "undefined";

    this.stringvalue = "deleteDate";

    let colorObs = this.notesService.moreoptions(id, this.dateAndTime, this.stringvalue);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }


  closelabelforNotes(id, labelId) {

    debugger;
    this.timer = false;

    this.notelabel = null;

    this.stringvalue = "closelabel";

    let colorObs = this.notesService.moreoptions(id, labelId, this.stringvalue);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }
  addlabelforNotes(id, labelId) {


    console.log("-------", id);
    console.log("-------", labelId);
    this.stringvalue = "addlabel";

    let colorObs = this.notesService.moreoptions(id, labelId, this.stringvalue);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }

  pinnednotes: boolean = false;
  pinnedlist: any;
  fetchPinned() {
    debugger;
    const email = localStorage.getItem('email');

    let getnotes = this.notesService.fetchPinnedNotes(email);

    getnotes.subscribe((res: any) => {
      debugger;
      // console.log("res", res);
      if (res != 0) {
        this.pinnednotes = true;
        this.pinnedlist = res as string[];
      }

    });
  }
  verticalPosition
  horizontalPosition
  setAutoHide
  autoHide
  actionButtonLabel
  action
  stat
  deleteNotes(id) {
    
    let config = new MatSnackBarConfig();
    config.verticalPosition = this.verticalPosition;
    config.horizontalPosition = this.horizontalPosition;
    config.duration = this.setAutoHide ? this.autoHide : 0;

    this.snackBar.open(this.stat, this.action ? this.actionButtonLabel : undefined, config);
    debugger;
    this.timer = false;

    this.dateAndTime = "1";

    this.stringvalue = "Delete";

    console.log(id);

    let colorObs = this.notesService.moreoptions(id, this.dateAndTime, this.stringvalue);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }

  openDialog(n): void {

    const dialogconfg = new MatDialogConfig();

    dialogconfg.autoFocus = true;

    dialogconfg.width = "600px"

    dialogconfg.panelClass = 'custom-dialog-container'

    dialogconfg.data = {

      notesdata: n

    }

    const open = this.dialog.open(EditnotesComponent, dialogconfg);

  }

  addNotes(labelId) {

    debugger;


    if ((this.title.value == "" && this.takeANote.value == "") || (this.title.value == null && this.takeANote.value == null) && this.dateAndTime == undefined) {

      this.flag = true;

    }
    else if (this.dateAndTime == undefined) {
      this.flag = true;
    }
    else {

      const email = localStorage.getItem('email');

      this.model = {

        "title": this.title.value,

        "takeANote": this.takeANote.value,

        "email": email,

        "color": this.backgroundColour,

        "image": this.mainimage,

        "pinned": this.pinnedvalue,

        "notelabelid": this.notelabelid,

      }

      let obs = this.notesService.usereNotes(this.model, this.dateAndTime);

      obs.subscribe((res: any) => {

        if (res.message == "200") {

          this.notesDisplaying();

          this.flag = true;
          this.title.setValue("");
          this.takeANote.setValue("");
          this.mainimage = "";
          this.backgroundColour = "white";
          this.dateAndTime = "undefined";
          this.timer = false;
        }

      });

    }

  }











  pinnedvalue;
  pinnedFunction(id, str) {
    if (id == '01') {
      this.pinnedvalue = '1';
    }
    else {
      if (str == "pinned") {
        var colorid = '0';
      }
      else if (str == "others") {
        var colorid = '1';
      }

      var flag = "pinned";


      this.notestools(id, colorid, flag);
    }
  }
  notestools(id, colorid, flag) {

    let colorObs = this.notesService.moreoptions(id, colorid, flag);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }
  openSnackBar(message: string, action: string) {

    this.snackBar.open(message, action, {

      duration: 2000,

    });

  }
  direct;
  difference;
  drop(event: CdkDragDrop<NotesModel[]>) {
    debugger;
    moveItemInArray(this.notelist, event.previousIndex, event.currentIndex);
    console.log("prev", event.previousIndex);
    console.log("cure", event.currentIndex);
    console.log("id")
    // if (event.previousIndex - event.currentIndex >= 2) {
    //   this.difference = event.previousIndex - event.currentIndex;
    //   this.direct = "positive";
    // }
    // else {
    //   this.difference = (event.previousIndex - event.currentIndex) * -0;
    //   this.direct = "negative";
    // }
  }
  labels

  fetchLabel() {
    debugger;
    var email = localStorage.getItem("email");
    debugger
    let fetchobs = this.labelsev.fetchLabel(email);

    fetchobs.subscribe((res: any) => {
      debugger
      this.labels = res;
    })
  }

  notelabel: any;
  notelabelid: any;
  newLabel
  labeldetails(labelname, id) {

    this.notelabel = labelname;
    this.notelabelid = id;
    this.labelb = true;

    if (this.newLabel != null) {

    }
    console.log("wowwwwwiiiii", id);

    console.log("wowwwwwiiiii", labelname);
  }

  mainlabel

  closes() {
    debugger
    console.log(this.mainlabel)
    this.notelabel = this.mainlabel;
    this.labelb = true;
    var email = localStorage.getItem("email");
    this.model = {
      "labelname": this.mainlabel
    }
    debugger;
    let labelobs = this.labelsev.setLabel(email, this.model);
    labelobs.subscribe((res: any) => {

    });
    this.mainlabel = null;
  }

  createlab: boolean = false;
  open() {

    this.createlab = true;

  }

}