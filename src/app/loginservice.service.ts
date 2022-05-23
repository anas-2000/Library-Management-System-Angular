import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { user } from './user';
import { books } from './books';
import { Requests } from './Requests';


@Injectable({
  providedIn: 'root'
})
export class LoginserviceService {

  constructor(private http: HttpClient) {

   }
   getData(url:string):Observable<any>{
     return this.http.get<user>(url);
   }
   addData(users:user):Observable<any>{
    return this.http.post<user>('http://lms/insertuser.php', users);
   }
   getBooks():Observable<books[]>{
     return this.http.get<books[]>('http://lms/booklist.php');
   }
   getRequests():Observable<Requests[]>{
    return this.http.get<Requests[]>('http://lms/requestlist.php');
   }
   sendRequest(request:Requests):Observable<Requests>{
     return this.http.post<Requests>('http://lms/sendRequest.php', request)
   }
}
