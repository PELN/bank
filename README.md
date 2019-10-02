# BANK
First semester exam at Web development  
Case: Develop a fullstack bank system

Subject: Web development  
Year: 2019  
Tools: HTML, CSS, PHP, Javascript, jQuery, AJAX, MAMP  
Solution: [http://pennylee.dk/bank/index]  
Documentation/Report: [http://peleno.net/portfolio/imgs/Web%20dev.%20exam%202019.pdf]  

---

## Detailed description

In the beginning of my web development course, we had to develop a fullstack banking system - where you were able to transfer money between phone numbers and much more.  

We build some of the components in class - the first 3 weeks, and then we had 1 week to build extra components for the exam.

Primarily we have been focusing on making API'S in PHP and connecting them with AJAX in javascript to update the information without reloading the browser.   

We used a local json file as database for learning purposes of using javascript with objects.   
The first 3 weeks we only learned about the backend, and the last week we had to combine it with the frontend both in design and validation.  

In our solution we also had to make an admin page for our internal bank - which could approve loans, block users and transfer money to customers.  

---

## How to use the system
To login you have to signup first.

You will receive an e-mail with a link to activate your account. (This might take some time - but you can set the 'active' in the json file to 1, and then you are able to login)

If you make another user, you can try to send money to that user's phone number.  
You might have to set the balance in the json file to an amount. 

Check the admin page by logging in with:   
Phone number: 30000000   
Password: 1234  
