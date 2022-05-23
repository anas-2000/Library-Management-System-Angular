import { NgForOf } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { books } from '../books';
import { LoginserviceService } from '../loginservice.service';
import { Requests } from '../Requests';

@Component({
  selector: 'app-student',
  templateUrl: './student.component.html',
  styleUrls: ['./student.component.css']
})
export class StudentComponent implements OnInit {
  book:books[];
  requestedbook:Requests;
  indexOfElement:number = 0;
  //book = new books();
  constructor(private loginservice: LoginserviceService) {
    this.book = [];
    this.requestedbook = new Requests();
  }

  ngOnInit(): void {
    this.loginservice.getBooks().subscribe((book:books[])=>{
      this.book = book;
    });
  }

  RequestBook(id:number){
    this.requestedbook.b_id = this.book[id].id;
    console.log(this.requestedbook);
    this.requestedbook.status = 'pending';
    this.loginservice.sendRequest(this.requestedbook).subscribe((request:Requests)=>{
      this.requestedbook=request;
      console.log(this.requestedbook);
    })
  }

}
