import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef } from '@angular/material';
import { LabelService } from 'src/app/Services/label.service';
import { FormControl } from '@angular/forms';
import{ LabelsModel  } from 'src/app/Models/labels.model';
@Component({
  selector: 'app-label',
  templateUrl: './label.component.html',
  styleUrls: ['./label.component.scss']
})
export class LabelComponent implements OnInit {

  labels: LabelsModel[]=[];

  constructor(
    public dialogRef: MatDialogRef<LabelComponent>,
    public dialog: MatDialog, private labelsev: LabelService,
    @Inject(MAT_DIALOG_DATA) public data: any,
  ) { }
email;
labelname = new FormControl();
model:any;
  ngOnInit() {


   this.fetchLabel();
   
  }
  fetchLabel() {
    this.email = localStorage.getItem("email");
    debugger
     let fetchobs = this.labelsev.fetchLabel(this.email);

     fetchobs.subscribe((res: any) => {
      debugger
      this.labels = res;
    })
  }

  closes() {
    this.model= {
      "labelname" : this.labelname.value
    }
    debugger
    let labelobs = this.labelsev.setLabel(this.email, this.model);
    labelobs.subscribe((res: any) => {

    });
  }
  closeslabel(){
    this.dialogRef.close();
  }
}
