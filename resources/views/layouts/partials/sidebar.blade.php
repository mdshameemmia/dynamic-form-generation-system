 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
         <div class=" mx-1">DFC System</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <li class="nav-item active">
         <a class="nav-link" href="{{ url('/dashboard') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>
     <li class="nav-item active">
         <a class="nav-link" href="{{ url('/dynamic_form/create') }}">
             <i class="fas fa-fw fa-pen-alt"></i>
             <span>Form Create</span></a>
     </li>
     <li class="nav-item active">
         <a class="nav-link" href="{{ url('/dynamic_form') }}">
             <i class="fas fa-fw fa-list-alt"></i>
             <span>Form List</span></a>
     </li>
     <li class="nav-item active">
         <a class="nav-link" href="{{ url('/') }}">
             <i class="fas fa-fw fa-redirect-alt"></i>
             <span>Back to Home</span></a>
     </li>
  

 </ul>
 <!-- End of Sidebar -->
