import { Component, OnInit } from '@angular/core';
import { MatSnackBar } from '@angular/material';
import { ListService } from 'src/app/Services/list.service';
import { TrashService } from 'src/app/Services/trash.service';
import { NotesModel } from 'src/app/Models/Notes.model';

@Component({
  selector: 'app-trash',
  templateUrl: './trash.component.html',
  styleUrls: ['./trash.component.scss']
})
export class TrashComponent implements OnInit {

  wrap: string = "wrap";
  direction: string = "row";
  layout: string = this.direction + " " + this.wrap;
  view: {};
  constructor(private trashserv : TrashService,
    private listview: ListService,

    private snackBar: MatSnackBar) {

    this.listview.getView().subscribe((res => {
      this.view = res;

      console.log("Direction is :", this.direction);

      this.layout = this.direction + " " + this.wrap;
      console.log("Layout is ", this.layout);
      // console.log("class is ", this.classcard);
    }));


   }
  notes: NotesModel[] = [];
  ngOnInit() {

    this.fetchTrash();
    this.listview.getView().subscribe((res => {
      this.view = res;

      this.layout = this.direction + " " + this.wrap;
    }));


    // setInterval(() => {
    //   this.fetchTrash();
		// }, 1000);
  }

  openSnackBar(message: string, action: string) {
    this.snackBar.open(message, action, {
      duration: 2000,
    });
  }
  
  fetchTrash(){
    debugger;
    const email = localStorage.getItem('email');

    let archiveobs = this.trashserv.fetchTrash(email);
    archiveobs.subscribe((res:any)=>{
      this.notes = res;
    }) 
  } 


  unTrash(id,flag){
    debugger

    let archive = this.trashserv.untrash(id,flag);
    archive.subscribe((res:any)=>{

    });


  }
  deleteNote(n) {
    let deleteObj = this.trashserv.deleteNotesFunction(n.id);


    deleteObj.subscribe((res: any) => {

      if (res.message == "200") {
        this.fetchTrash();
      }
      else {

      }
    });
  }


}
