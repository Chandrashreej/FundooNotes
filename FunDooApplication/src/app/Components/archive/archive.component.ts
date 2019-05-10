import { Component, OnInit } from '@angular/core';
import { ArchiveService } from 'src/app/Services/archive.service';
import { NotesModel } from 'src/app/Models/Notes.model';
import * as jwt_decode from "jwt-decode";
import { ListService } from 'src/app/Services/list.service';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition, MatSnackBarConfig } from '@angular/material';
@Component({
  selector: 'app-archive',
  templateUrl: './archive.component.html',
  styleUrls: ['./archive.component.scss']
})
export class ArchiveComponent implements OnInit {
  classcard(arg0: string, classcard: any): any {
    throw new Error("Method not implemented.");
  }


  wrap: string = "wrap";
  direction: string = "row";
  layout: string = this.direction + " " + this.wrap;
  view: {};
  constructor(private archserv : ArchiveService,
    private listview: ListService,

    private snackBar: MatSnackBar) {

    this.listview.getView().subscribe((res => {
      this.view = res;

      console.log("Direction is :", this.direction);

      this.layout = this.direction + " " + this.wrap;
      console.log("Layout is ", this.layout);
      console.log("class is ", this.classcard);
    }));


   }
  notes: NotesModel[] = [];
  ngOnInit() {

    this.fetchArchive();
    this.listview.getView().subscribe((res => {
      this.view = res;

      this.layout = this.direction + " " + this.wrap;
    }));


    // setInterval(() => {
    //   this.fetchArchive();
		// }, 1000);
  }

  // openSnackBar(message: string, action: string) {
  //   this.snackBar.open(message, action, {
  //     duration: 2000,
  //   });
  // }
  
  fetchArchive(){
    debugger;
    const email = localStorage.getItem('email');

    let archiveobs = this.archserv.fetchArchive(email);
    archiveobs.subscribe((res:any)=>{
      this.notes = res;
    }) 
  } 

  horizontalPosition: MatSnackBarHorizontalPosition = 'start';
  verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  actionButtonLabel: string = 'Undo';
  action: boolean = true;
  setAutoHide: boolean = true;
  autoHide: number = 2000;
  addExtraClass: boolean = true;
  unarchive(id,flag){
    debugger
    let config = new MatSnackBarConfig();
    config.verticalPosition = this.verticalPosition;
    config.horizontalPosition = this.horizontalPosition;
    config.duration = this.setAutoHide ? this.autoHide : 0;
    config.panelClass = ["font-family:'Open Sans', sans-serif;font-color: green;"];

    this.snackBar.open('note binned', this.action ? this.actionButtonLabel: undefined, config);
    debugger;



    let archive = this.archserv.unarchived(id,flag);
    archive.subscribe((res:any)=>{

    });

this.fetchArchive();
  }

}
