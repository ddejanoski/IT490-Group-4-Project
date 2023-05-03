<?php
require(__DIR__ . "/navbar.php");
require('/home/nicole/Documents/IT490/RabbitMQClientGame.php'); 
?>

<!DOCTYPE html>

<html>
  <head>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  </head>

    <h1> Welcome <?php echo $_SESSION['email']; ?> </h1>
    <p> Use the arrow keys to move your Professor </p>
    <p> Shoot the aliens with the spacebar and score as many points as possible </p>

    <canvas id="canvas2" width="600" height="400" tabindex="1" style="position: absolute; left: 250; top: 250; z-index: 0;"> </canvas>
    <canvas id="canvas" width="600" height="400" tabindex="1" style="position: absolute; left: 250; top: 250; z-index: 0;"> </canvas>
    
    <div class="hidden">
      <script type="text/javascript">
          if (document.images){
            professor = new Image();
            professor.src = "pictures/professor-v2.jpg";
            alien = new Image();
            alien.src = "pictures/alien.jpg";
          }
      </script>
    </div>
    
    
    <form id="scoreForm" onsubmit="return false">
          <input type="hidden" id="score" name="score" value=0>
    </form> 
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

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
context.clearRect(0, 0, 600, 400);

var canvas2 = document.getElementById('canvas2');
var context2 = canvas2.getContext('2d');

var background = new Image();
background.src = "pictures/proisgamebg.jpg";
background.onload = function(){
  context2.drawImage(background, -150, 0, 800, 800 * background.height/background.width);
}

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

function makeEnemySquare(x, y, length, speed) {
  return {
    x: x,
    y: y,
    l: length,
    s: speed,
    draw: function() {
      context.drawImage(alien, this.x, this.y, this.l, this.l);
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

var ship = makeShip(50, canvas.height / 2 - 25, 50, 7);
var shipHard = makeShip(50, canvas.height / 2 - 25, 50, 5);

var easySquare = makeLevelSelectSquare(canvas.width - 100, 65, 50, "#00FF00");
var difficultSquare = makeLevelSelectSquare(canvas.width-100, 270, 50, "#000000");

var up = false;
var down = false;
var space = false;

var shooting = false;

var bullet = makeSquare(0, 0, 10, 10);

var enemies = [];

var easyLevel = true;
var hardLevel = false;

var enemyBaseSpeed = 4;
function makeEnemy() {
  var enemyX = canvas.width;
  var enemySize = Math.round((Math.random() * 15)) + 15;
  var enemyY = Math.round(Math.random() * (canvas.height - enemySize * 2)) + enemySize;
  enemies.push(makeEnemySquare(enemyX, enemyY, enemySize, enemyBaseSpeed));
}

function isWithin(a, b, c) {
  return (a > b && a < c);
}

function isColliding(a, b) {
  var result = false;
  if (isWithin(a.x, b.x, b.x + b.l) || isWithin(a.x + a.l, b.x, b.x + b.l)) {
    if (isWithin(a.y, b.y, b.y + b.l) || isWithin(a.y + a.l, b.y, b.y + b.l)) {
      result = true;
    }
  }
  return result;
}

var score = 0;

var timeBetweenEnemies = 5 * 1000;

var timeoutId = null;

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

canvas.addEventListener('keyup', function(event) {
  event.preventDefault();
  if (event.keyCode === 38) { // UP 
    up = false;
  }
  if (event.keyCode === 40) { // DOWN
    down = false;
  }
});

function erase() {
  context.clearRect(0, 0, 600, 400);
}

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

    canvas.addEventListener('click', levelSelect);
}

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

  if (down) {
    ship.y += ship.s;
  }
  if (up) {
    ship.y -= ship.s;
  }

  if (ship.y < 0) {
    ship.y = 0;
  }
  if (ship.y > canvas.height - ship.l) {
    ship.y = canvas.height - ship.l;
  }

  ship.draw();

  easySquare.draw();
  difficultSquare.draw();

  if (shooting) {
    bullet.x += bullet.s;

    if (isColliding(bullet, easySquare)) {
      startGame(1);
      levelSelected = true;
    }
    if (isColliding(bullet, difficultSquare)) {
      startGame(0);
      levelSelected = true;
    }

    if (bullet.x > canvas.width) {
      shooting = false;
    }

    context.fillStyle = '#0000FF';
    bullet.draw();
  }

  if (levelSelected == false) {
    window.requestAnimationFrame(levelSelect);
  }
  canvas.removeEventListener('click', levelSelect);
}

function startGame(difficulty) {
  erase();
  score = 0;
  document.getElementById('score').value=score;

  timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
  setTimeout(makeEnemy, 1000);

  if (difficulty == 1){
    drawEasy();
  }
  else if(difficulty == 0){
    drawHard();
    easyLevel = false;
    hardLevel = true;
  }

  canvas.removeEventListener('click', startGame);
}

function endGame() {
  clearInterval(timeoutId);
  erase();
  while(enemies.length > 0){
    enemies.pop();
  }
  enemyBaseSpeed = 2;
  easyLevel = true;
  hardLevel = false;

  $.ajax({
    method: "POST",
    url: "/game.php",
    data: {"score": score}
  })
  .done(function(html){
    console.log(score);
  });

  context.font = 'bold 24px Arial';
  context.textAlign = 'center';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Game Over. Click to Restart. Final Score: ' + score, canvas.width / 2, canvas.height / 2);
  context.fillStyle = 'white';
  context.fillText('Game Over. Click to Restart. Final Score: ' + score, canvas.width / 2, canvas.height / 2);
  
  canvas.addEventListener('click', levelSelect);
}

function drawEasy() {
  erase();
  var gameOver = false;

  enemies.forEach(function(enemy) {
    enemy.x -= enemy.s;
    if (enemy.x < 0) {
      gameOver = true;
    }
    enemy.draw();
  });

  enemies.forEach(function(enemy, i) {
    if (isColliding(enemy, ship)) {
      gameOver = true;
    }
  });

  if (down) {
    ship.y += ship.s;
  }
  if (up) {
    ship.y -= ship.s;
  }

  if (ship.y < 0) {
    ship.y = 0;
  }
  if (ship.y > canvas.height - ship.l) {
    ship.y = canvas.height - ship.l;
  }

  ship.draw();

  if (shooting) {
    bullet.x += bullet.s;

    enemies.forEach(function(enemy, i) {
      if (isColliding(bullet, enemy)) {
        enemies.splice(i, 1);
        score++;
        shooting = false;
      }
    });

    if (bullet.x > canvas.width) {
      shooting = false;
    }
  
    context.fillStyle = '#0000FF';
    bullet.draw();
  }

  context.font = 'bold 24px Arial';
  context.textAlign = 'left';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Score: ' + score, 1, 25)
  context.fillStyle = 'white';
  context.fillText('Score: ' + score, 1, 25)

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

  enemies.forEach(function(enemy) {
    enemy.x -= enemy.s;
    if (enemy.x < 0) {
      gameOver = true;
    }
    context.fillStyle = '#00FF00';
    enemy.draw();
  });

  enemies.forEach(function(enemy, i) {
    if (isColliding(enemy, shipHard)) {
      gameOver = true;
    }
  });

  if (down) {
    shipHard.y += shipHard.s;
  }
  if (up) {
    shipHard.y -= shipHard.s;
  }

  if (shipHard.y < 0) {
    shipHard.y = 0;
  }
  if (shipHard.y > canvas.height - shipHard.l) {
    shipHard.y = canvas.height - shipHard.l;
  }

  shipHard.draw();

  if (shooting) {
    bullet.x += bullet.s;

    enemies.forEach(function(enemy, i) {
      if (isColliding(bullet, enemy)) {
        enemies.splice(i, 1);
        score++;
        shooting = false;
        
        if (score % 5 === 0 && timeBetweenEnemies > 1000) {
          clearInterval(timeoutId);
          timeBetweenEnemies -= 1000;
          timeoutId = setInterval(makeEnemy, timeBetweenEnemies);
        } else if (score % 2 === 0) {
          enemyBaseSpeed += 2;
        } 
      }
    });

    if (bullet.x > canvas.width) {
      shooting = false;
    }

    bullet.draw();
  }

  context.font = 'bold 24px Arial';
  context.textAlign = 'left';
  context.strokeStyle = 'black';
  context.lineWidth = 8;
  context.strokeText('Score: ' + score, 1, 25)
  context.fillStyle = 'white';
  context.fillText('Score: ' + score, 1, 25)

  if (gameOver) {
    endGame();
    shooting = false;
  } else {
    window.requestAnimationFrame(drawHard);
  }
}

menu();
canvas.focus();
</script>