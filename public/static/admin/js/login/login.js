var bezier,
    layouts,
    cloudMotion,
    sketch,
    aboutPanel,
    gui,
    app,
    settings,
    take,
    main;



// "bezier" by Mathias Paumgarten
bezier = (function(){

    var proto = {

        t: 0,

        addAnchor: function( point ) {
            if ( ! this.anchors ) this.anchors = [];

            this.anchors.push( { x: point.x, y: point.y } );
            this.update();
        },

        setPosition: function( value ) {
            this.t = value;
            this.update();
        },

        update: function() {
            var t = this.t || 0;
            var anchors = this.anchors || [];
            var length = anchors.length;
            var points = [];
            var i, j;

            for ( i = 0; i < length; i++ ) {
                points[ i ] = { x: anchors[ i ].x, y: anchors[ i ].y };
            }

            for ( j = 1; j < length; ++j ) {
                for (i = 0; i < length - j; ++i ) {
                    points[ i ].x = ( 1 - t ) * points[ i ].x + t * points[ ~~( i + 1 ) ].x;
                    points[ i ].y = ( 1 - t ) * points[ i ].y + t * points[ ~~( i + 1 ) ].y;
                }
            }

            this.x = points[ 0 ].x;
            this.y = points[ 0 ].y;
        },

        get: function() {
            return { x: this.x, y: this.y };
        }

    };

    var Bezier = function(){};
    Bezier.prototype = Object.create(proto);

    function bezier() {
        return new Bezier();
    }

    return bezier;
})();

//"cloud motion" by Mathias Paumgarten
cloudMotion = (function(bezier){

    function CloudMotion( radius, speed ) {

        speed = speed || 0.01;

        var points = [];
        var curve;
        var current = 0;

        function init() {
            points.push( getRandomPoint() );
            points.push( getRandomPoint() );
            points.push( getRandomPoint() );

            initCurve();
        }

        function initCurve() {
            curve = bezier();
            curve.addAnchor( points[ 0 ].interpolateTo( points[ 1 ], 0.5 ) );
            curve.addAnchor( points[ 1 ] );
            curve.addAnchor( points[ 1 ].interpolateTo( points[ 2 ], 0.5 ) );
        }

        function getRandomPoint() {
            var pt = new toxi.geom.Vec2D();
            pt.x = toxi.math.MathUtils.random( radius / 3, radius );
            pt.y = Math.random() * Math.PI * 2;
            return pt.toCartesian();
        }

        this.update = function() {
            current += speed;

            if ( current >= 1 ) {
                points.shift();
                points.push( getRandomPoint() );
                initCurve();
                current -= 1;
            }

            curve.setPosition( current );
        };

        this.getPosition = function() {
            return curve.get();
        };

        init();
    }

    return function( radius, speed ) {
        return new CloudMotion( radius, speed );
    };
})(bezier);


//The main rendering of the sketch
sketch = (function( cloudMotion ){

    var exports = {},
        canvas = document.createElement('canvas'),
        ctx = canvas.getContext('2d'),
        center = new toxi.geom.Vec2D(),
        focus = new toxi.geom.Vec2D(),
        circles = [],
        color = toxi.color.TColor.newHex('3b2141').setAlpha(0.015),
        motion,
        drawTangents;


    exports.clear = function(){
        canvas.width = window.innerWidth * 2;
        canvas.height = window.innerHeight * 2;

        canvas.style.width = window.innerWidth + 'px';
        canvas.style.height = window.innerHeight + 'px';

        center.set(canvas.width, canvas.height).scaleSelf(0.5);
        focus.set(center);
        ctx.clearRect(0,0,canvas.width,canvas.height);
    };

    exports.clear();
    motion = cloudMotion(1000, 0.1);

    drawTangents = function(ctx, pt, circle, color){
        var isecs = circle.getTangentPoints(pt);
        if( isecs ){
            ctx.strokeStyle = color.toRGBACSS();
            isecs.forEach(function(isec){
                ctx.beginPath();

                var ray = new toxi.geom.Ray2D(pt, isec.sub(pt)),
                    line = ray.toLine2DWithPointAtDistance(canvas.width);
                ctx.moveTo(line.a.x, line.a.y);
                ctx.lineTo(line.b.x, line.b.y);
                ctx.closePath();
                ctx.stroke();
            });

        }
    };

    var color1 = color.copy(),
        color2 = toxi.color.TColor.newHex('ffdb4d')
            .adjustHSV(0,-0.01,0.25)
            .setAlpha(0.015);


    color2 = toxi.color.NamedColor.GOLD
        .copy()
        .setAlpha(0.015);


    var colors = [color1, color2];
    //call this function every frame to render the sketch
    function render(frameCount){
        focus.set(motion.getPosition()).addSelf(center);
        //add a subtle white fill
        ctx.fillStyle = 'rgba(255,255,255,0.001)';
        ctx.fillRect(0,0,canvas.width,canvas.height);
        circles.forEach(function( circle, i ){
            drawTangents( ctx, focus, circle, colors[i%colors.length] );
        });

    }

    exports.el = canvas;
    exports.center = center;
    exports.colors = colors;

    //provide the sketch with the layout of toxi.geom.Circle's
    exports.setCircles = function( _circles ){
        circles = _circles;
    };


    exports.setMotion = function( radius, speed ){
        exports.loop.off('update', motion.update);
        motion = cloudMotion( radius, speed );
        exports.loop.on('update', motion.update);
    };

    exports.loop = animitter()
        .on('update', motion.update)
        .on('update', render);

    return exports;

})( cloudMotion );



//call `fn` `num` times, collecting results
take = function( num, fn ){
    var results = [];
    for( var i=0; i<num; i++ ){
        results.push( fn(i, num) );
    }
    return results;
};

//methods to determine where the circles are plotted
layouts = (function(toxi, sketch, take){
  
    var exports = {},
        el = sketch.el;


    exports.random = function( num ){
        return take( num, function(i, total){
            return new toxi.geom.Circle(
                Math.random()*el.width,
                Math.random()*el.height,
                toxi.math.MathUtils.random(el.width*0.005, el.width)
            );
        });
    };


    exports.concentric = function( num, position, options ){
        options = options || {};
        var minRadius = options.minRadius || 10,
            maxRadius = options.maxRadius || el.width/3,
            interp = options.interpolator || new toxi.math.LinearInterpolation();
        return take( num, function(i, total){
            return new toxi.geom.Circle(
                position,
                interp.interpolate(minRadius, maxRadius, i/total)
            );
        });
    };


    exports.combination = function( num, position ){
        var numRandom = ~~toxi.math.MathUtils.random(num/4, num),
            numConcentric = num - numRandom;
        return exports.random(numRandom).concat(exports.concentric(numConcentric, position));
    };


    return exports;

})(window.toxi, sketch, take);


//the panel with my name on it
aboutPanel = (function(){

    var exports = {},
        create,
        svg,
        setPath,
        aboutEl = document.body.querySelector('.about.title'),
        randomizeEl = document.body.querySelector('.btn.randomize'),
        interp = new toxi.math.SigmoidInterpolation(),
        paths = [];



    create = function(type){
        return document.createElementNS('http://www.w3.org/2000/svg', type);
    };


    setPath = function(points, path ){
        path = path || create('path');
        //build the path "d" attribute
        var d = points.reduce(function(str, pt){
            str += pt.x + ' ' + pt.y + ' ';
            return str;
        }, 'M ');
        //close the path
        d += 'Z';
        path.setAttribute('d', d);
        return path;
    };





    exports.el = svg = create('svg');
    svg.classList.add('about');

    var poly = {};

    poly.from = new toxi.geom.Rect({
        x: 0,
        y: 0,
        width: 200,
        height: 0
    }).toPolygon2D();

    poly.to = new toxi.geom.Rect({
        x: 0,
        y: 0,
        width: 200,
        height: 150
    }).toPolygon2D();

    poly.current = poly.from.copy();

    var faces = [
        [ 0, 1, 3 ],
        [ 1, 2, 3 ]
    ];

    var colors = [
        {
            from: toxi.color.TColor.newHex('cccccc'),
            to: toxi.color.TColor.newHex('ffffff')
        },
        {
            from: toxi.color.TColor.newHex('999999'),
            to: toxi.color.TColor.newHex('ffffff')
        }
    ];

    colors.forEach(function(color){
        color.current = color.from.copy();
    });


    var tweenColor = function( colorIndex, delayFrames, durationFrames ){
        return function(frameCount){
            var f = frameCount - delayFrames;
            f = toxi.math.MathUtils.clip(f / durationFrames, 0, 1);
            var color = colors[colorIndex];
            color.current.setRGB( color.from.copy().blend(color.to,f).rgb );
        };
    };

    var tweenVertex = function( vertIndex, delayFrames, durationFrames ){
        return function(frameCount){
            var f = frameCount - delayFrames;
            f = toxi.math.MathUtils.clip(f / durationFrames, 0, 1);
            var c = poly.current.vertices[vertIndex],
                from = poly.from.vertices[vertIndex],
                to = poly.to.vertices[vertIndex];

            c.set( from.interpolateTo(to, f, interp) );
        };
    };


    var extract = function( arr, idxArr ){
        return idxArr.map(function(i){
            return arr[i];
        });
    };

    var tris;

    var makePaths = function(){
        tris = faces.map(function(face){
            return extract(poly.current.vertices,face);
        });

        paths = tris.map(function(tri){
            var path = setPath(tri);
            path.style.strokeWidth = '1px';
            return path;
        });

        paths.forEach(function(path){
            svg.appendChild(path);
        });
    };

    var render = function(){
        tris.forEach(function(tri,i){
            var path = paths[i];
            var color = colors[i].current;
            path.style.fill = color.toRGBCSS();
            path.style.stroke = color.toRGBCSS();
            setPath(tri, path);
        });
    };

    exports.loop = animitter()
        .once('start', makePaths)
        .on('update', tweenColor(0, 0, 30))
        .on('update', tweenColor(1, 30, 30))
        .on('update', tweenVertex(1, 0, 15))
        .on('update', tweenVertex(3, 0, 30))
        .on('update', tweenVertex(2, 15, 30))
        .on('update', render)
        .on('update', function(frameCount){
            if( frameCount === 60 ){
                this.emit('fade-text');
            }
        })
        .on('fade-text', function(){
            //aboutEl.classList.add('active');
            this.complete();
        });

    return exports;

})();



//some of the basic configuration
settings = {
    numCircles: 50,
    layout: 'random',
    colors: sketch.colors,
    motionRadius: 2000,
    motionSpeed: 0.1
};


//control all of the pieces
app = {
    updateMotion: function(){
        sketch.setMotion(settings.motionRadius, settings.motionSpeed);
    },
    randomize: function(){
        var coin = toxi.math.MathUtils.flipCoin;
        var generator = {
            layout: function(){
                var types = Object.keys(layouts);
                return types[~~toxi.math.MathUtils.random(0,types.length)];
            },
            numCircles: function(){
                var r = toxi.math.MathUtils.random;
                if( settings.layout === 'concentric' ){
                    return ~~r(20,60);
                }
                return ~~(coin() ? r(100,50) : coin() ? r(120,200) : r(25,50));
            },
            motionRadius: function(){
                return coin() ? 1000 : 2000;
            },
            motionSpeed: function(){
                return coin() ? 0.1 : coin() ? 0.01 : 0.003;
            }
        };

        for( var prop in generator ){
            settings[prop] = generator[prop]();
        }
        app.reset();
    },
    reset: function(){
        sketch.clear();
        sketch.setCircles( layouts[settings.layout](settings.numCircles, sketch.center) );
        sketch.setMotion( settings.motionRadius, settings.motionSpeed );
        sketch.loop.start();
    },
    resume: function(){
        sketch.loop.start();
    },
    pause: function(){
        sketch.loop.stop();
    }
};

//create the gui in the top-right
gui = (function(settings, app, layouts){

    var gui = new dat.GUI();
    gui.close();
    gui.add(settings, 'numCircles', 1, 200)
        .step(1)
        .listen();
    gui.add(settings, 'layout', Object.keys(layouts))
        .listen();
    gui.add(settings,'motionRadius', 10, sketch.el.width)
        .listen()
        .onFinishChange(app.updateMotion);
    gui.add(settings, 'motionSpeed', 0.001, 0.15)
        .step(0.001)
        .listen()
        .onFinishChange(app.updateMotion);
    gui.add(app, 'pause');
    gui.add(app, 'resume');
    gui.add(app, 'reset');
    return gui;

})(settings, app, layouts);


var timer = null;

function Interval() {
    timer = setInterval(function(){
        $('.btn.randomize').trigger('click');
    }, 20000)
}

//kick off the sketch
main = function(){
    document.body.appendChild(sketch.el);
    document.body.appendChild(aboutPanel.el);

    document.body.querySelector('.btn.randomize').addEventListener('click', app.randomize);
    window.addEventListener('resize', app.reset);
    
    $('canvas').click(function(){
        $('.btn.randomize').trigger('click');
        clearInterval(timer)
        Interval()
    })
    Interval()
    
    
    
    //transition in info panel
    setTimeout(function(){
        aboutPanel.loop.start();
    }, 6000);

    app.reset();
};


window.onload = main;

