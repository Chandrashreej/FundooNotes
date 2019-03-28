import { Component, OnInit } from '@angular/core';
import { FormControl } from '@angular/forms';
import { DashboardService } from 'src/app/Services/dashboardService/ServiceNotes';
import * as moment from 'moment';
import { ListService } from 'src/app/Services/list.service';
import { MoreoptionsService } from 'src/app/Services/moreoptions.service';
import { MatDialog, MatIconRegistry, MatSnackBar, MatDialogConfig } from '@angular/material';
import { DomSanitizer } from '@angular/platform-browser';
import { EditnotesComponent } from '../editnotes/editnotes.component';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.scss']
})
export class NotesComponent implements OnInit {
  flag: boolean = true;
  token1: any;
  notelist: any;
  classcard;
  notes: any;
  backgroundColour: any;
  constructor(private notesService: DashboardService, private listview: ListService, private moreoptService:MoreoptionsService,
    public dialog: MatDialog,
    iconRegistry: MatIconRegistry,
    sanitizer: DomSanitizer,
    private snackBar: MatSnackBar
    ) {

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
  timer: any;
  title = new FormControl();
  displayTitle: any;
  displayTakeANote: any;
  takeANote = new FormControl();
  dateandtime: any;
  dateAndTimeCustom = new FormControl;
  wrap: string = "wrap";
  direction: string = "row";
  dialogbox:boolean = false;
  layout: string = this.direction + " " + this.wrap;
  /**
 * var to hold present time
 */
  public dateAndTime: any;
  view;
  ngOnInit() {
    this.notesDisplaying();
    this.timer = false;

    this.listview.getView().subscribe((res => {
      this.view = res;
      this.direction = this.view.data;
      this.layout = this.direction + " " + this.wrap;
    }))
  }
  notesDisplaying() {

    const email = localStorage.getItem('email');
    let getnotes = this.notesService.fetchnotes(email);
    getnotes.subscribe((res: any) => {

      this.notelist = res as string[];
      this.displayTitle = this.notelist.title;
      this.displayTakeANote = this.notelist.takeANote;

    });
  }
  colourSetter(color)
  {
    this.backgroundColour = color;
  }
	coloring(id,value) {
		debugger;
this.dialogbox =true;
			let obs = this.moreoptService.coloringBackground(id, value);
			obs.subscribe((res: any) => {
				debugger;
				this.notes = res;
        this.notesDisplaying();
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
  openDialog(n): void {
    
    debugger
    const dialogconfg = new MatDialogConfig();

    dialogconfg.autoFocus = true;
    dialogconfg.width = "600px"
    dialogconfg.height = "180px"
    dialogconfg.panelClass = 'custom-dialog-container'
    debugger; 
    dialogconfg.data = {

      notesdata: n
     
    }
    const open = this.dialog.open(EditnotesComponent, dialogconfg);

	}
  addNotes() {
    // debugger;
    if (this.title.value == null && this.takeANote.value == null && this.dateAndTime== undefined) {
      this.flag = true;
    }
    else {
      const email = localStorage.getItem('email');
 
      this.model = {
        "title": this.title.value,
        "takeANote": this.takeANote.value,
        "email": email,
        "color":this.backgroundColour
      }
      // console.log(this.model);
      // debugger;
      let obs = this.notesService.usereNotes(this.model, this.dateAndTime);
      //this.dateAndTime 

      // debugger;
      obs.subscribe((res: any) => {
        if (res.message == "200") {

          this.notesDisplaying();
          this.flag = true;
        }
      });
    }

  }
  openSnackBar(message: string, action: string) {
    this.snackBar.open(message, action, {
      duration: 2000,
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
