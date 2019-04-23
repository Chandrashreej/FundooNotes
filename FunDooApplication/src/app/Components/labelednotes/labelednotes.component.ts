import { Component, OnInit } from '@angular/core';
import { CdkDragDrop, moveItemInArray } from '@angular/cdk/drag-drop';
import { EditnotesComponent } from '../editnotes/editnotes.component';
import { MatDialogConfig, MatSnackBar, MatIconRegistry, MatDialog } from '@angular/material';
import * as moment from 'moment';
import { DomSanitizer } from '@angular/platform-browser';
import { ListService } from 'src/app/Services/list.service';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import { FormControl } from '@angular/forms';
import { NotesModel } from 'src/app/Models/Notes.model';
import { LabelidService } from 'src/app/Services/labelid.service';
import { LabelService } from 'src/app/Services/label.service';

@Component({
  selector: 'app-labelednotes',
  templateUrl: './labelednotes.component.html',
  styleUrls: ['./labelednotes.component.scss']
})
export class LabelednotesComponent implements OnInit {

  model: any = {};
  notesarray: NotesModel[] = [];

  flag: boolean = true;

  notelist: any;
  classcard;
  notes: any;
  backgroundColour: any;
  timer: any;
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


  constructor(private notesService: DashboardService,
    private listview: ListService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,
    private snackBar: MatSnackBar,
    private name: LabelidService,
    private labser: LabelService
  ) {

    this.listview.getView().subscribe((res => {

      this.view = res;

      this.direction = this.view.data;

      this.classcard = this.view.class;

      this.layout = this.direction + " " + this.wrap;

    }));


    this.labeledNotesotesDisplaying();
  }
  labelname: string;


  fetchImage() {

    // debugger;

    var email = localStorage.getItem("email");

    let fetchobs = this.notesService.fectImageService(email);


    fetchobs.subscribe((res: any) => {

      // debugger

      this.mainimage = res;

    })

  }


  mainimage;
  imageid;

  selectedImage(event, id) {

    // debugger;

    this.imageid = id;

    var files = event.target.files;

    var file = files[0];

    if (files && file) {

      var reader = new FileReader();

      reader.onload = this._handleReaderLoaded.bind(this);

      reader.readAsBinaryString(file);

    }
  }

  base64textString
  imagepre
  present
  _handleReaderLoaded(readerEvt) {

    // debugger;

    var binarstring = readerEvt.target.result;

    this.base64textString = btoa(binarstring);

    if (this.imageid != "01") {
      this.present = false;
      this.imagepre = true;
      this.mainimage = "data:image/jpeg;base64," + this.base64textString;

      var flag = "image";
      this.notestools(this.imageid, this.mainimage, flag)

    }
    else {
      this.mainimage = "data:image/jpeg;base64," + this.base64textString;
    }

  }
  lablesss
  ngOnInit() {
    this.labeledNotesotesDisplaying();
    this.fetLabelName();
    this.name.getsetLabelName().subscribe((res => {

      console.log("----------------============", res);
      this.lablesss = res;

      this.labelname = this.lablesss.data;
      console.log("hhhhhhhhhhhhhhhhhh", this.labelname);



    }));

    this.labeledPinnedNotesDisplaying();


    this.timer = false;

    this.listview.getView().subscribe((res => {

      this.view = res;

      this.direction = this.view.data;

      this.layout = this.direction + " " + this.wrap;

    }));

    // setInterval(() => {

    //   this.remaindme();

    // }, 1000);

  }

  fetLabelName() {
    debugger;


  }

  timeChooser(str) {

    // debugger;
    var chooser = moment(this.dateChooser.value).format("DD/MM/YYYY");

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

  duplicate
  DateAndTime
  remaindme() {

    // debugger;
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
        // debugger;
        this.snackBar.open(reminder.title, ' ', { duration: 2000 });
        alert("their is reminder" + reminder.title);
      }
    });

  }


  today(id) {

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
  imagerOfNotes
  labeledNotesotesDisplaying() {
    debugger;
    const email = localStorage.getItem('email');
    // console.log("reyyhgvhgjghjh",this.labelname);
    let getnotes = this.labser.fetchLabeledNotes(email, this.labelname);

    getnotes.subscribe((res: any) => {
      debugger
      // console.log("resabghbv", res);
      debugger;
      this.notelist = res as string[];

    });
  }
  pinnedlist: string[];
  labeledPinnedNotesDisplaying() {

    const email = localStorage.getItem('email');

    let getnotes = this.labser.fetchLabeledPinnedNotes(email, this.labelname);

    getnotes.subscribe((res: any) => {

      // console.log("res", res);
      // debugger;
      this.pinnedlist = res as string[];



    });
  }
  colourSetter(color) {

    this.backgroundColour = color;

  }
  str;
  coloring(id, value) {

    // debugger;

    this.str = "color";

    let obs = this.notesService.coloringBackground(id, value, this.str);

    obs.subscribe((res: any) => {

      this.notes = res;

      this.labeledNotesotesDisplaying();

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

    let colorObs = this.notesService.coloringBackground(id, this.dateAndTime, this.stringvalue);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }

  fetchPinned() {

    const email = localStorage.getItem('email');

    let getnotes = this.notesService.fetchPinnedNotes(email);

    getnotes.subscribe((res: any) => {

      console.log("res", res);

      this.notelist = res as string[];

      this.displayTitle = this.notelist.title;

      this.displayTakeANote = this.notelist.takeANote;

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

  addNotes() {

    // debugger;



    const email = localStorage.getItem('email');

    this.model = {

      "title": this.title.value,

      "takeANote": this.takeANote.value,

      "email": email,





      // "color": this.backgroundColour,

      // "image": this.mainimage

    }

    let obs = this.notesService.labeledNotes(this.model, this.dateAndTime, this.labelname);

    obs.subscribe((res: any) => {

      if (res.message == "200") {

        this.labeledNotesotesDisplaying();

        this.flag = true;

      }

    });



  }

  notestools(id, colorid, flag) {

    let colorObs = this.notesService.coloringBackground(id, colorid, flag);

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
  drop(event: CdkDragDrop<string[]>) {
    debugger;
    moveItemInArray(this.notelist, event.previousIndex, event.currentIndex);
    // if (event.previousIndex - event.currentIndex >= 2) {
    //   this.difference = event.previousIndex - event.currentIndex;
    //   this.direct = "positive";
    // }
    // else {
    //   this.difference = (event.previousIndex - event.currentIndex) * -0;
    //   this.direct = "negative";
    // }
  }

}
