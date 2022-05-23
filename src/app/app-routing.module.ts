import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminscreenComponent } from './adminscreen/adminscreen.component';
import { FacultyComponent } from './faculty/faculty.component';
import { LoginComponent } from './login/login.component';
import { StudentComponent } from './student/student.component';
import { SupplierComponent } from './supplier/supplier.component';

const routes: Routes = [{path:'login', component: LoginComponent },{path:'adminscreen', component:AdminscreenComponent},{path:'student', component:StudentComponent},
{path:'faculty', component:FacultyComponent}, {path: 'supplier', component: SupplierComponent}];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
