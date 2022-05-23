import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { user } from '../user';
import { LoginserviceService } from '../loginservice.service';
import { Router } from '@angular/router';
import { Requests } from '../Requests';

@Component({
  selector: 'app-adminscreen',
  templateUrl: './adminscreen.component.html',
  styleUrls: ['./adminscreen.component.css']
})





export class AdminscreenComponent implements OnInit {
  userform:FormGroup
  message:string;
  requests:Requests[];
  constructor(private fb:FormBuilder, private loginservice: LoginserviceService, private router:Router) {
    
    this.requests = [];

    const atLeastOne = (validator: ValidatorFn, controls:string[] = null) => (
      group: FormGroup,
    ): ValidationErrors | null => {
      if(!controls){
        controls = Object.keys(group.controls)
      }
    
      const hasAtLeastOne = group && group.controls && controls
        .some(k => !validator(group.controls[k]));
    
      return hasAtLeastOne ? null : {
        atLeastOne: true,
      };
    };

    this.userform = this.fb.group({
      name:['', Validators.required],
      username: ['', [Validators.required, Validators.email]],
      password:['', Validators.required],
      usertype:['', Validators.required],
      department:[''],
      address:['']
      
    },{ validator: atLeastOne(Validators.required, ['department','address']) });
    this.message = "";
   }
   

  ngOnInit(): void {
  }

  RegisterUser(form: {value:user;}){
    this.loginservice.addData(form.value).subscribe((users:user)=>{
      console.log(users);
      if(users.id == 0){
        this.message = "Username already exists";
      }
      else{
        this.message = "User '"+users.username+"' registered successfully"; 
      }
    });

  }
  OpenRequests(){

  }
  showForm(){
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }


    document.getElementById("form").style.display = "block";

    
  }
  
  showRequests(){
    this.loginservice.getRequests().subscribe((requests:Requests[])=>{
      this.requests = requests;
    })
    document.getElementById("requests").style.display = "block";
  }
  showAction(){
    document.getElementById("actionContainer").style.display ="block";
  }
  approveRequest(){

  }
  denyRequest(){
    
  }
}
