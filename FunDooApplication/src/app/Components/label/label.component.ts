import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialog, MatDialogRef } from '@angular/material';
import { LabelService } from 'src/app/Services/label.service';

@Component({
  selector: 'app-label',
  templateUrl: './label.component.html',
  styleUrls: ['./label.component.scss']
})
export class LabelComponent implements OnInit {
  labels: any;

  constructor(
    public dialogRef: MatDialogRef<LabelComponent>,
    public dialog: MatDialog, private labelsev: LabelService,
    @Inject(MAT_DIALOG_DATA) public data: any,
  ) { }

  ngOnInit() {


  //   this.fetchLabel();
  }
  // fetchLabel() {
  //   debugger
  //   // let fetchobs = this.labelsev.fetchLabel(this.uid);

  //   // fetchobs.subscribe((res: any) => {
  //     debugger
  //     this.labels = res;
  //   })
  // }

  // closes(value: any) {
  //   debugger
  //   let labelobs = this.labelsev.setLabel(this.uid, value);
  //   labelobs.subscribe((res: any) => {

  //   });
  // }
}
