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
  dateChooser= new FormControl();
  isDate: boolean;
  image:any;
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
    this.image = this.data.notesdata.image;

    this.dateAndTime = this.data.notesdata.dateAndTime;
  }
 dateAndTime: any;

  ngOnInit() {
    this.timer = false;
    this.isDate = true;
    if(this.data.notesdata.dateAndTime == "undefined")
    {
      this.isDate = false;
    }
  }
  timeChooser( str) {
    debugger;
    var chooser = moment(this.dateChooser.value).format("DD/MM/YYYY");
        if (str == "Morning") {
          this.dateAndTime = chooser+ " " + " 08:00 AM ";
          // this.timer = true;
          
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
        this.timer = true;
        this.isDate=false;
        var flag = "reminderValue";
        var id = this.id
        this.notestools(id, this.dateAndTime, flag);


      }
      imageid
      mainimage
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
      notelabelid: any;
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
      "notelabelid": this.notelabelid,

    }
    

    let obs = this.notesService.usereNotesDialog(this.model, this.dateAndTime, this.id);

    obs.subscribe((res: any) => {
      if (res.message == "200") {
        
      }
    });
    this.dialogRef.close();
  }

  notestools(id, colorid, flag) {

    let colorObs = this.notesService.moreoptions(id, colorid, flag);

    colorObs.subscribe((res: any) => {

      if (res.status == "200") {

      }

    });
  }

  colourSetter(color) {
    this.color = color;
  }
  str;
  coloring(id, value) {
    debugger;
this.str ="color";
    let obs = this.notesService.moreoptions(id, value,this.str);
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

this.isDate=false;
  }


  tomorrow(id) {
    var day = new Date();

    day.setDate(day.getDate() + 1);

    this.fulldate = day.toDateString();

    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");

    this.dateAndTime = currentDate + " " + " 08:00 AM";

    if (id != '01') {
      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }
    this.timer = true;
    this.isDate=false;
  }

  nextWeek(id) {
    var day = new Date();

    this.fulldate = day.setDate(day.getDate() + ((1 + 7 - day.getDay()) % 7));

    let currentDate = moment(this.fulldate).format("DD/MM/YYYY");

    this.dateAndTime = currentDate + " " + " 08:00 AM";


    if (id != '01') {
      var flag = "reminderValue";
      this.notestools(id, this.dateAndTime, flag);

    }
    this.timer = true;
    this.isDate=false;
  }
  closedate() {

    this.timer = false;

    this.dateAndTime = "undefined";

  }
  labelb: boolean = false;
  notelabel: any;
  closelabel() {

    this.labelb = false;

    this.notelabel = null;

  }
  stringvalue
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

}