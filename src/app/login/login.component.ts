import { ChangeDetectorRef, Component, NgZone, OnInit } from '@angular/core';
import {user} from '../user';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { LoginserviceService } from '../loginservice.service';
import { BehaviorSubject } from 'rxjs';
import { Router } from '@angular/router';



@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  users = new user();
  type:string;
  admin_name:string;
  admin_password:string;
  url:string = "";
  myForm: FormGroup;
  message:string;
  current_username:string;
  current_password:string;


  constructor(private fb:FormBuilder, private loginservice: LoginserviceService, private ngZone: NgZone, private ref: ChangeDetectorRef, private router:Router) {
    this.myForm = this.fb.group({
      username:['',[Validators.required, Validators.email]],
      password:['', Validators.required],
      usertype: ['', Validators.required]
    });
    this.admin_name = "admin@live.com";
    this.admin_password = "password";
    this.message = "";
   
  }
   

  testEmitter$ = new BehaviorSubject<user>(this.users);

  ngOnInit(): void {
    
    
  }  
  

  
    getUser(form:FormGroup){
    this.type = this.myForm.value.usertype;
    if(this.type == "admin"){// checking if user is admin
      this.current_username = this.myForm.value.username;
      this.current_password = this.myForm.value.password;
     if( this.checkCred(this.admin_name, this.admin_password)){
       this.navigate('/adminscreen');
     }
    }
    else{
      this.url = "http://localhost/esp-server/server.php?username="+form.value.username+"&password="+form.value.password; 
      this.loginservice.getData(this.url).subscribe((users) => {
        
        this.ngZone.run( () => {
          this.users = users;
          this.current_username = this.myForm.value.username;
          this.current_password = this.myForm.value.password;
          this.checkCred(this.users.username, this.users.password);
          
          
      });
      });
    }
   }
   checkCred(username:string, password:string):boolean{

     if(username == this.current_username && password == this.current_password){
       this.message = "login successful";
       this.navigate('/'+this.type);
       return true;
     }
     else{
       this.message = "Invalid username or password";
       return false;
     }
   }

   navigate(url:string){
    this.router.navigate([url]);
   }

  onSubmit(form: FormGroup){
    this.getUser(form);
  }
  
}
