 <!-- NAVBAR -->
 <?php include 'navbar.php'; ?>

 <main>
   <div class="container">

     <!-- HERO -->
     <section class="hero">
       <div class="hero-tag">🛡️ Secure & Transparent System</div>
       <h1>Your Voice,<br><span>Heard & Resolved</span></h1>
       <p>Submit complaints, track their status in real-time, and get resolutions — all in one modern platform.</p>
       <div class="hero-btns">
         <a href="complaint.php" class="btn btn-primary">📝 File a Complaint</a>
         <a href="register.php" class="btn btn-outline">Create Account</a>
       </div>
     </section>

     <!-- FEATURES -->
     <section>
       <p class="section-title" style="text-align:center;">Why ComplaintHub?</p>
       <div class="features">
         <div class="feature-card">
           <div class="f-icon">⚡</div>
           <h3>Fast Resolution</h3>
           <p>Complaints are reviewed and acted upon within 48 hours of submission.</p>
         </div>
         <div class="feature-card">
           <div class="f-icon">🔍</div>
           <h3>Real-time Tracking</h3>
           <p>Track every status update of your complaint with full transparency.</p>
         </div>
         <div class="feature-card">
           <div class="f-icon">🔒</div>
           <h3>Secure & Private</h3>
           <p>Your data is encrypted and kept confidential at all times.</p>
         </div>
         <div class="feature-card">
           <div class="f-icon">📊</div>
           <h3>Admin Dashboard</h3>
           <p>Admins get powerful tools to manage, filter, and resolve complaints.</p>
         </div>
       </div>
     </section>

     <!-- HOW IT WORKS -->
     <section style="margin-bottom: 4rem;">
       <p class="section-title" style="text-align:center; margin-bottom: 0.5rem;">How it works</p>
       <h2 style="text-align:center; margin-bottom: 2.5rem;">3 Simple Steps</h2>
       <div class="features" style="grid-template-columns: repeat(3, 1fr);">
         <div class="feature-card" style="text-align:center;">
           <div style="font-size:2.5rem; font-family: var(--font-display); color: var(--accent); font-weight:800;">01</div>
           <h3>Register</h3>
           <p>Create a free account to start submitting complaints.</p>
         </div>
         <div class="feature-card" style="text-align:center;">
           <div style="font-size:2.5rem; font-family: var(--font-display); color: var(--accent); font-weight:800;">02</div>
           <h3>Submit</h3>
           <p>Fill out the complaint form with all relevant details.</p>
         </div>
         <div class="feature-card" style="text-align:center;">
           <div style="font-size:2.5rem; font-family: var(--font-display); color: var(--accent); font-weight:800;">03</div>
           <h3>Track</h3>
           <p>Log in anytime to check the status of your complaint.</p>
         </div>
       </div>
     </section>

   </div>
 </main>

 <!-- FOOTER -->
 <?php include 'footer.php'; ?>