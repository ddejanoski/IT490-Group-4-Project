<?php
require(__DIR__ . "/navbar.php");
include('/home/nicole/Documents/IT490/RabbitMQClientGame.php'); 
?>

<!DOCTYPE html>

<html>
    <h1> This is the Game Page </h1>
    <p> Welcome <?php echo $_SESSION['email']; ?> </p>
    <p> Use the arrow keys to move your Professor </p>
    <p> Shoot the aliens with the spacebar and score as many points as possible </p>

    <canvas id="canvas2" width="600" height="400" tabindex="1" style="position: absolute; left: 100; top: 100; z-index: 0;"> </canvas>
    <canvas id="canvas" width="600" height="400" tabindex="1" style="position: absolute; left: 100; top: 100; z-index: 0;"> </canvas>
    
    <div class="hidden">
      <script type="text/javascript">
          if (document.images){
            professor = new Image();
            professor.src = "pictures/professor-v2.jpg";
          }
      </script>
    </div>
  </body>
</html>

<style>
    #canvas {
    width: 600px;
    height: 400px;
    border: 1px solid black;
    background: transparent;
    }

    #canvas2 {
      width: 600px;
      height: 400px;
      border: 1px solid black;
      opacity: 0.5;
    }

</style>

<script>

// Arcade Shooter game

// Get a reference to the canvas DOM element
var canvas = document.getElementById('canvas');
// Get the canvas drawing context
var context = canvas.getContext('2d');
context.clearRect(0, 0, 600, 400);




var canvas2 = document.getElementById('canvas2');
// Get the canvas drawing context
var context2 = canvas2.getContext('2d');

var background = new Image();
background.src = "pictures/proisgamebg.jpg";
background.onload = function(){
  context2.drawImage(background, -150, 0, 800, 800 * background.height/background.width);
}

var pattern = context.createPattern(professor, 'no-repeat');


// Create an object representing a square on the canvas
function makeSquare(x, y, length, speed) {
  return {
    x: x,
    y: y,
    l: length,
    s: speed,
    draw: function() {
      context.fillRect(this.x, this.y, this.l, this.l);
    }
  };
}

function makeShip(x, y, length, speed) {
  return {
    x: x,
    y: y,
    l: length,
    s: speed,
    draw: function() {
      context.drawImage(professor, this.x, this.y, this.l, this.l);
    }
  };
}

function makeLevelSelectSquare(x, y, length, color) {
  return{
    x: x,
    y: y,
    l: length,
    draw: function() {
      context.fillStyle = color;
      context.fillRect(this.x, this.y, this.l, this.l)
    }
  }
}

// The ship the user controls
var ship = makeShip(50, canvas.height / 2 - 25, 50, 4);
var shipHard = makeShip(50, canvas.height / 2 - 25, 50, 3);

//level select squares
var easySquare = makeLevelSelectSquare(canvas.width - 100, 65, 50, "#00FF00");
var difficultSquare = makeLevelSelectSquare(canvas.width-100, 270, 50, "#000000");


// Flags to tracked which keys are pressed
var up = false;
var down = false;
var space = false;

// Is a bullet already on the canvas?
var shooting = false;
// The bulled shot from the ship
var bullet = makeSquare(0, 0, 10, 10);

// An array for enemies (in case there are more than one)
var enemies = [];

var easyLevel = true;
var hardLevel = false;

// Add an enemy object to the array
var enemyBaseSpeed = 2;
function makeEnemy() {
  var enemyX = canvas.width;
  var enemySize = Math.round((Math.random() * 15)) + 15;
  var enemyY = Math.round(Math.random() * (canvas.height - enemySize * 2)) + enemySize;
  enemies.push(makeSquare(enemyX, enemyY, enemySize, enemyBaseSpeed));
}

// Check if number a is in the range b to c (exclusive)
function isWithin(a, b, c) {
  return (a > b && a < c);
}

// Return true if two squares a and b are colliding, false otherwise
function isColliding(a, b) {
  var result = false;
  if (isWithin(a.x, b.x, b.x + b.l) || isWithin(a.x + a.l, b.x, b.x + b.l)) {
    if (isWithin(a.y, b.y, b.y + b.l) || isWithin(a.y + a.l, b.y, b.y + b.l)) {
      result = true;
    }
  }
  return result;
}

// Track the user's score
var score = 0;
// The delay between enemies (in milliseconds)
var timeBetweenEnemies = 5 * 1000;
// ID to track the spawn timeout
var timeoutId = null;

// Listen for keydown events
canvas.addEventListener('keydown', function(event) {
  event.preventDefault();
  if (event.keyCode === 38) { // UP
    up = true;
  }
  if (event.keyCode === 40) { // DOWN
    down = true;
  }
  if (event.keyCode === 32) { // SPACE
    shoot();
  }
});

// Listen for keyup events
canvas.addEventListener('keyup', function(event) {
  event.preventDefault();
  if (event.keyCode === 38) { // UP 
    up = false;
  }
  if (event.keyCode === 40) { // DOWN
    down = false;
  }
});

// Clear the canvas
function erase() {
  //context.fillStyle = '#FFFFFF';
  context.clearRect(0, 0, 600, 400);
  //context.fillRect(0, 0, 600, 400);
}

// Shoot the bullet (if not already on screen)
function shoot() {
  shooting = true;
  if(easyLevel == true){
    bullet.x = ship.x + ship.l;
    bullet.y = ship.y + ship.l / 2;
  }
  if(hardLevel == true){
    bullet.x = shipHard.x + shipHard.l;
    bullet.y = shipHard.y + shipHard.l / 2;
  }
  
}

// Show the game menu and instructions
function menu() {
    erase();
    context.font = 'bold 36px Arial';
    context.textAlign = 'center';
    context.strokeStyle = 'black';
    context.lineWidth = 8;
    context.strokeText('Professor in Space', canvas.width / 2, canvas.height / 4);
    context.fillStyle = 'white';
    context.fillText('Professor in Space', canvas.width / 2, canvas.height / 4);

    context.font = 'bold 24px Arial';
    context.strokeText('Click to Start', canvas.width / 2, canvas.height / 2);
    context.fillText('Click to Start', canvas.width / 2, canvas.height / 2);

    context.font = 'bold 18px Arial';
    context.strokeText('Up/Down to move, Space to shoot.', canvas.width / 2, (canvas.height / 4) * 3);
    context.fillText('Up/Down to move, Space to shoot.', canvas.width / 2, (canvas.height / 4) * 3);
    // Start the game on a click
    canvas.addEventListener('click', levelSelect);

}

//select level
function levelSelect() {
  var levelSelected = false;
  erase();

  context.font = 'bold 36px Arial';
  context.textAlign = 'center';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText("Shoot your Difficulty", canvas.width / 2, canvas.height / 4);
  context.fillStyle = 'white';
  context.fillText("Shoot your Difficulty", canvas.width / 2, canvas.height / 4);

  context.font = 'bold 18px Arial';
  context.textAlign = 'center';
  context.strokeText("Green for Easy, Black for Hard", canvas.width / 2, canvas.height / 3);
  context.fillText("Green for Easy, Black for Hard", canvas.width / 2, canvas.height / 3);


    // Move the ship
  if (down) {
    ship.y += ship.s;
  }
  if (up) {
    ship.y -= ship.s;
  }
  // Don't go out of bounds
  if (ship.y < 0) {
    ship.y = 0;
  }
  if (ship.y > canvas.height - ship.l) {
    ship.y = canvas.height - ship.l;
  }
  // Draw the ship
  context.fillStyle = pattern;
  ship.draw();
  //console.log(ship.x + " "+ ship.y)
  easySquare.draw();
  difficultSquare.draw();

  if (shooting) {
    // Move the bullet
    bullet.x += bullet.s;
    // Collide the bullet with enemies
    if (isColliding(bullet, easySquare)) {
      startGame(1);
      levelSelected = true;
    }
    if (isColliding(bullet, difficultSquare)) {
      startGame(0);
      levelSelected = true;
    }
    // Collide with the wall
    if (bullet.x > canvas.width) {
      shooting = false;
    }
    // Draw the bullet
    context.fillStyle = '#0000FF';
    bullet.draw();
  }

  if (levelSelected == false) {
    window.requestAnimationFrame(levelSelect);
  }
  canvas.removeEventListener('click', levelSelect);
}


// Start the game
function startGame(difficulty) {
  erase();
	// Kick off the enemy spawn interval
    score = 0;
    //console.log("Welcome to the start game");
  timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
  // Make the first enemy
  setTimeout(makeEnemy, 1000);
  // Kick off the draw loop
  if (difficulty == 1){
    drawEasy();
  }
  else if(difficulty == 0){
    drawHard();
    easyLevel = false;
    hardLevel = true;
  }
  // Stop listening for click events
  canvas.removeEventListener('click', startGame);
}


// Show the end game screen
function endGame() {
	// Stop the spawn interval
  clearInterval(timeoutId);
  // Show the final score
  erase();
  while(enemies.length > 0){
    enemies.pop();
  }
  enemyBaseSpeed = 2;
  easyLevel = true;
  hardLevel = false;

  context.font = 'bold 24px Arial';
  context.textAlign = 'center';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Game Over. Click to Restart. Final Score: ' + score, canvas.width / 2, canvas.height / 2);
  context.fillStyle = 'white';
  context.fillText('Game Over. Click to Restart. Final Score: ' + score, canvas.width / 2, canvas.height / 2);
  
  canvas.addEventListener('click', levelSelect);

}



// The main draw loop
function drawEasy() {
  erase();
  var gameOver = false;
  //console.log("Made it into the easy draw loop");
  //console.log(gameOver);
  // Move and draw the enemies
  enemies.forEach(function(enemy) {
    enemy.x -= enemy.s;
    if (enemy.x < 0) {
      gameOver = true;
    }
    context.fillStyle = '#00FF00';
    enemy.draw();
  });
  // Collide the ship with enemies
  enemies.forEach(function(enemy, i) {
    if (isColliding(enemy, ship)) {
      gameOver = true;
    }
  });
  // Move the ship
  if (down) {
    ship.y += ship.s;
  }
  if (up) {
    ship.y -= ship.s;
  }
  // Don't go out of bounds
  if (ship.y < 0) {
    ship.y = 0;
  }
  if (ship.y > canvas.height - ship.l) {
    ship.y = canvas.height - ship.l;
  }
  // Draw the ship
  context.fillStyle = '#FF0000';
  ship.draw();
  // Move and draw the bullet
  if (shooting) {
    // Move the bullet
    bullet.x += bullet.s;
    // Collide the bullet with enemies
    enemies.forEach(function(enemy, i) {
      if (isColliding(bullet, enemy)) {
        enemies.splice(i, 1);
        score++;
        shooting = false;

        /*
        // Make the game harder
        if (score % 10 === 0 && timeBetweenEnemies > 1000) {
          clearInterval(timeoutId);
          timeBetweenEnemies -= 1000;
          timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
        } else if (score % 5 === 0) {
          enemyBaseSpeed += 1;
        } */


      }
    });
    // Collide with the wall
    if (bullet.x > canvas.width) {
      shooting = false;
    }
    // Draw the bullet
    context.fillStyle = '#0000FF';
    bullet.draw();
  }
  // Draw the score
  context.font = 'bold 24px Arial';
  context.textAlign = 'left';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Score: ' + score, 1, 25)
  context.fillStyle = 'white';
  context.fillText('Score: ' + score, 1, 25)

  // End or continue the game
  if (gameOver) {
    endGame();
    shooting = false;
  } else {
    window.requestAnimationFrame(drawEasy);
  }
}

function drawHard() {
  erase();
  var gameOver = false;
  //console.log("Made it into the draw loop");
  //console.log(gameOver);
  // Move and draw the enemies
  enemies.forEach(function(enemy) {
    enemy.x -= enemy.s;
    if (enemy.x < 0) {
      gameOver = true;
    }
    context.fillStyle = '#00FF00';
    enemy.draw();
  });
  // Collide the ship with enemies
  enemies.forEach(function(enemy, i) {
    if (isColliding(enemy, shipHard)) {
      gameOver = true;
    }
  });
  // Move the ship
  if (down) {
    shipHard.y += shipHard.s;
  }
  if (up) {
    shipHard.y -= shipHard.s;
  }
  // Don't go out of bounds
  if (shipHard.y < 0) {
    shipHard.y = 0;
  }
  if (shipHard.y > canvas.height - shipHard.l) {
    shipHard.y = canvas.height - shipHard.l;
  }
  // Draw the ship
  context.fillStyle = '#FF0000';
  shipHard.draw();
  // Move and draw the bullet
  if (shooting) {
    // Move the bullet
    bullet.x += bullet.s;
    // Collide the bullet with enemies
    enemies.forEach(function(enemy, i) {
      if (isColliding(bullet, enemy)) {
        enemies.splice(i, 1);
        score++;
        shooting = false;
        // Make the game harder

        
        if (score % 5 === 0 && timeBetweenEnemies > 1000) {
          clearInterval(timeoutId);
          timeBetweenEnemies -= 1000;
          timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
        } else if (score % 2 === 0) {
          enemyBaseSpeed += 2;
        } 
      }
    });
    // Collide with the wall
    if (bullet.x > canvas.width) {
      shooting = false;
    }
    // Draw the bullet
    context.fillStyle = '#0000FF';
    bullet.draw();
  }
  // Draw the score
  context.font = 'bold 24px Arial';
  context.textAlign = 'left';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Score: ' + score, 1, 25)
  context.fillStyle = 'white';
  context.fillText('Score: ' + score, 1, 25)
  // End or continue the game
  if (gameOver) {
    endGame();
    shooting = false;
  } else {
    window.requestAnimationFrame(drawHard);
  }
}

// Start the game
menu();
canvas.focus();



</script>