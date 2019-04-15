import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LabelednotesComponent } from './labelednotes.component';

describe('LabelednotesComponent', () => {
  let component: LabelednotesComponent;
  let fixture: ComponentFixture<LabelednotesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LabelednotesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LabelednotesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
