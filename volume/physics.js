const thickness = 60;
const SVG_PATH_SELECTOR = "#matter-path";
const SVG_WIDTH_IN_PX = 100;
const SVG_WIDTH_AS_PERCENT_OF_CONTAINER_WIDTH = 0.1;
const matterContainer = document.querySelector("#matter-container");

// module aliases
const Engine = Matter.Engine,
Render = Matter.Render,
Runner = Matter.Runner,
Bodies = Matter.Bodies,
Composite = Matter.Composite,
Body = Matter.Body,
Svg = Matter.Svg,
Vector = Matter.Vector,
Vertices = Matter.Vertices;

// create an engine
var engine = Engine.create();

// create a renderer
var render = Render.create({
    element: matterContainer,
    engine: engine,
    options: {
    width: matterContainer.clientWidth,
    height: matterContainer.clientHeight,
    background: "transparent",
    wireframes: false,
    showAngleIndicator: false
    }
});

var ground = Bodies.rectangle(
    matterContainer.clientWidth / 2,
    matterContainer.clientHeight + thickness / 2,
    27184,
    thickness,
    { isStatic: true }
);

let leftWall = Bodies.rectangle(
    0 - thickness / 2,
    matterContainer.clientHeight / 2,
    thickness,
    matterContainer.clientHeight * 5,
    {
        isStatic: true
    }
);

let rightWall = Bodies.rectangle(
    matterContainer.clientWidth + thickness / 2,
    matterContainer.clientHeight / 2,
    thickness,
    matterContainer.clientHeight * 5,
    { isStatic: true }
);

// add all of the bodies to the world
Composite.add(engine.world, [ground, leftWall, rightWall]);

let mouse = Matter.Mouse.create(render.canvas);
let mouseConstraint = Matter.MouseConstraint.create(engine, {
    mouse: mouse,
    constraint: {
        stiffness: 0.2,
        render: {
        visible: false
        }
    }
});

Composite.add(engine.world, mouseConstraint);

// allow scroll through the canvas
mouseConstraint.mouse.element.removeEventListener(
    "mousewheel",
    mouseConstraint.mouse.mousewheel
);
mouseConstraint.mouse.element.removeEventListener(
    "DOMMouseScroll",
    mouseConstraint.mouse.mousewheel
);

// run the renderer
Render.run(render);

// create runner
var runner = Runner.create();

// run the engine
Runner.run(runner, engine);

// create a circle for the 'o' of volume
function createCircle() {
    let circleDiameter = 170;
    let circle = Bodies.circle(
    matterContainer.clientWidth / 3,
    10,
    circleDiameter / 3,
    {
        friction: 0.3,
        frictionAir: 0.005,
        restitution: 0.8,
        render: {
        fillStyle: "#464655",
        strokeStyle: "#464655"
        }
    }
    );
    return circle;
}

// create a rectangle with rounded edges for the 'u' of volume
function createRectangle() {
    let width = 160;
    let height = 170;
    let rectangle = Bodies.rectangle(
      matterContainer.clientWidth / 2,
      10,
      width,
      height,
      {
        chamfer: {
          radius: [0,0,60,60]
        },
        friction: 0.3,
        frictionAir: 0.05,
        restitution: 0.8,
        render: {
          fillStyle: "#464655",
          strokeStyle: "#464655"
        }
      }
    );
    return rectangle;
}

// create bodies from SVGs on the site
function createSvgBodies(path, index) {
    let vertices = Svg.pathToVertices(path);
    vertices = Vertices.scale(vertices, 1.5, 1.5);
    let svgBody = Bodies.fromVertices(
        100,
        0,
        [vertices],
        {
            friction: 0.3,
            firctionAir: 0.05,
            restitution: 0.8,
            render: {
                fillStyle: "#464655",
                strokeStyle: "#464655",
                lineWidth: 1
            }
        }
    );
    return svgBody;
}

function positionBodies() {
    yVol = 0
    letters.forEach(letter => {
        Body.setPosition(letter, {
            x: matterContainer.clientWidth /2,
            y: yVol,
        })
    Body.setVelocity(letter, { x: 0, y: 0 })
    yVol -= 250
    })
}

function scaleLetters() {
    const allBodies = Composite.allBodies(engine.world);
    allBodies.forEach((body) => {
      if (body.isStatic === true) return; // don't scale walls and ground
      const { min, max } = body.bounds;
      const bodyWidth = max.x - min.x;
      let scaleFactor =
        (matterContainer.clientWidth * SVG_WIDTH_AS_PERCENT_OF_CONTAINER_WIDTH) /
        bodyWidth;
      
      Body.scale(body, scaleFactor, scaleFactor);
    });
  }

function handleResize(matterContainer) {
    // set canvas size to new values
    render.canvas.width = matterContainer.clientWidth;
    render.canvas.height = matterContainer.clientHeight;
  
    // reposition ground
    Body.setPosition(
      ground,
      Vector.create(
        matterContainer.clientWidth / 2,
        matterContainer.clientHeight + thickness / 2
      )
    );
  
    // reposition right wall
    Body.setPosition(
      rightWall,
      Vector.create(
        matterContainer.clientWidth + thickness / 2,
        matterContainer.clientHeight / 2
      )
    );

    // scaleLetters();
  }

window.addEventListener("resize", () => handleResize(matterContainer));

// store the letters of 'volume'
const chars = document.querySelectorAll(SVG_PATH_SELECTOR);
var letters = []
chars.forEach((char, i) => {
    if (i === 1 ) {
      letters.push(createCircle())
    } else {
      letters.push(createSvgBodies(char, i))
    }
    
})

letters.forEach((letter, i) => {
  Composite.add(engine.world, letter);
})
//Composite.add(engine.world, letters);
positionBodies()
