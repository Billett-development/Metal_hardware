<?php

namespace Vsourz\Imagegallery\Model;

class Enum
{
	
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    const ALIGN_LEFT = "left";
    const ALIGN_CENTER = "center";
    const ALIGN_RIGHT = "right";

    const ANIMATION_NONE = false;
    const ANIMATION_BOUNCE = "bounce";
	const ANIMATION_FLASH = "flash";
	const ANIMATION_PULSE = "pulse";
	const ANIMATION_RUBBERBAND = "rubberBand";
	const ANIMATION_SHAKE = "shake";
	const ANIMATION_HEADSHAKE = "headShake";
	const ANIMATION_TADA = "tada";
	const ANIMATION_WOBBLE = "wobble";
	const ANIMATION_JELLO = "jello";
	const ANIMATION_SWING = "swing";
	const ANIMATION_BOUNCEIN = "bounceIn";
	const ANIMATION_BOUNCEINDOWN = "bounceInDown";
	const ANIMATION_BOUNCEINLEFT = "bounceInLeft";
	const ANIMATION_BOUNCEINRIGHT = "bounceInRight";
	const ANIMATION_BOUNCEINUP = "bounceInUp";
	const ANIMATION_FADEIN = "fadeIn";
	const ANIMATION_FADEINDOWN = "fadeInDown";
	const ANIMATION_FADEINDOWNBIG = "fadeInDownBig";
	const ANIMATION_FADEINLEFT = "fadeInLeft";
	const ANIMATION_FADEINLEFTBIG = "fadeInLeftBig";
	const ANIMATION_FADEINRIGHT = "fadeInRight";
	const ANIMATION_FADEINRIGHTBIG = "fadeInRightBig";
	const ANIMATION_FADEINUP = "fadeInUp";
	const ANIMATION_FADEINUPBIG = "fadeInUpBig";
	const ANIMATION_FLIPINX = "flipInX";
	const ANIMATION_FLIPINY = "flipInY";
	const ANIMATION_LIGHTSPEEDIN = "lightSpeedIn";
	const ANIMATION_ROTATEIN = "rotateIn";
	const ANIMATION_ROTATEINDOWNLEFT = "rotateInDownLeft";
	const ANIMATION_ROTATEINDOWNRIGHT = "rotateInDownRight";
	const ANIMATION_ROTATEINUPLEFT = "rotateInUpLeft";
	const ANIMATION_ROTATEINUPRIGHT = "rotateInUpRight";
	const ANIMATION_HINGE = "hinge";
	const ANIMATION_ROLLIN = "rollIn";
	const ANIMATION_ZOOMIN = "zoomIn";
	const ANIMATION_ZOOMINDOWN = "zoomInDown";
	const ANIMATION_ZOOMINLEFT = "zoomInLeft";
	const ANIMATION_ZOOMINRIGHT = "zoomInRight";
	const ANIMATION_ZOOMINUP = "zoomInUp";
	const ANIMATION_SLIDEINDOWN = "slideInDown";
	const ANIMATION_SLIDEINLEFT = "slideInLeft";
	const ANIMATION_SLIDEINRIGHT = "slideInRight";
	const ANIMATION_SLIDEINUP = "slideInUp";
	const ANIMATION_BOUNCEOUT = "bounceOut";
	const ANIMATION_BOUNCEOUTDOWN = "bounceOutDown";
	const ANIMATION_BOUNCEOUTLEFT = "bounceOutLeft";
	const ANIMATION_BOUNCEOUTRIGHT = "bounceOutRight";
	const ANIMATION_BOUNCEOUTUP = "bounceOutUp";
	const ANIMATION_FADEOUT = "fadeOut";
	const ANIMATION_FADEOUTDOWN = "fadeOutDown";
	const ANIMATION_FADEOUTDOWNBIG = "fadeOutDownBig";
	const ANIMATION_FADEOUTLEFT = "fadeOutLeft";
	const ANIMATION_FADEOUTLEFTBIG = "fadeOutLeftBig";
	const ANIMATION_FADEOUTRIGHT = "fadeOutRight";
	const ANIMATION_FADEOUTRIGHTBIG = "fadeOutRightBig";
	const ANIMATION_FADEOUTUP = "fadeOutUp";
	const ANIMATION_FADEOUTUPBIG = "fadeOutUpBig";
	const ANIMATION_ANIMATEDFLIP = "animatedflip";
	const ANIMATION_FLIPOUTX = "flipOutX";
	const ANIMATION_FLIPOUTY = "flipOutY";
	const ANIMATION_LIGHTSPEEDOUT = "lightSpeedOut";
	const ANIMATION_ROTATEOUT = "rotateOut";
	const ANIMATION_ROTATEOUTDOWNLEFT = "rotateOutDownLeft";
	const ANIMATION_ROTATEOUTDOWNRIGHT = "rotateOutDownRight";
	const ANIMATION_ROTATEOUTUPLEFT = "rotateOutUpLeft";
	const ANIMATION_ROTATEOUTUPRIGHT = "rotateOutUpRight";
	const ANIMATION_ROLLOUT = "rollOut";
	const ANIMATION_ZOOMOUT = "zoomOut";
	const ANIMATION_ZOOMOUTDOWN = "zoomOutDown";
	const ANIMATION_ZOOMOUTLEFT = "zoomOutLeft";
	const ANIMATION_ZOOMOUTRIGHT = "zoomOutRight";
	const ANIMATION_ZOOMOUTUP = "zoomOutUp";
	const ANIMATION_SLIDEOUTDOWN = "slideOutDown";
	const ANIMATION_SLIDEOUTLEFT = "slideOutLeft";
	const ANIMATION_SLIDEOUTRIGHT = "slideOutRight";
	const ANIMATION_SLIDEOUTUP = "slideOutUp";

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

    public static function getInAnimations(){
    	return [
			self::ANIMATION_NONE => __("None"),
			self::ANIMATION_BOUNCE => __("bounce"),
			self::ANIMATION_FLASH => __("flash"),
			self::ANIMATION_PULSE => __("pulse"),
			self::ANIMATION_RUBBERBAND => __("rubberBand"),
			self::ANIMATION_SHAKE => __("shake"),
			self::ANIMATION_HEADSHAKE => __("headShake"),
			self::ANIMATION_TADA => __("tada"),
			self::ANIMATION_WOBBLE => __("wobble"),
			self::ANIMATION_JELLO => __("jello"),
			self::ANIMATION_SWING => __("swing"),
			self::ANIMATION_BOUNCEIN => __("bounceIn"),
			self::ANIMATION_BOUNCEINDOWN => __("bounceInDown"),
			self::ANIMATION_BOUNCEINLEFT => __("bounceInLeft"),
			self::ANIMATION_BOUNCEINRIGHT => __("bounceInRight"),
			self::ANIMATION_BOUNCEINUP => __("bounceInUp"),
			self::ANIMATION_FADEIN => __("fadeIn"),
			self::ANIMATION_FADEINDOWN => __("fadeInDown"),
			self::ANIMATION_FADEINDOWNBIG => __("fadeInDownBig"),
			self::ANIMATION_FADEINLEFT => __("fadeInLeft"),
			self::ANIMATION_FADEINLEFTBIG => __("fadeInLeftBig"),
			self::ANIMATION_FADEINRIGHT => __("fadeInRight"),
			self::ANIMATION_FADEINRIGHTBIG => __("fadeInRightBig"),
			self::ANIMATION_FADEINUP => __("fadeInUp"),
			self::ANIMATION_FADEINUPBIG => __("fadeInUpBig"),
			self::ANIMATION_FLIPINX => __("flipInX"),
			self::ANIMATION_FLIPINY => __("flipInY"),
			self::ANIMATION_LIGHTSPEEDIN => __("lightSpeedIn"),
			self::ANIMATION_ROTATEIN => __("rotateIn"),
			self::ANIMATION_ROTATEINDOWNLEFT => __("rotateInDownLeft"),
			self::ANIMATION_ROTATEINDOWNRIGHT => __("rotateInDownRight"),
			self::ANIMATION_ROTATEINUPLEFT => __("rotateInUpLeft"),
			self::ANIMATION_ROTATEINUPRIGHT => __("rotateInUpRight"),
			self::ANIMATION_HINGE => __("hinge"),
			self::ANIMATION_ROLLIN => __("rollIn"),
			self::ANIMATION_ZOOMIN => __("zoomIn"),
			self::ANIMATION_ZOOMINDOWN => __("zoomInDown"),
			self::ANIMATION_ZOOMINLEFT => __("zoomInLeft"),
			self::ANIMATION_ZOOMINRIGHT => __("zoomInRight"),
			self::ANIMATION_ZOOMINUP => __("zoomInUp"),
			self::ANIMATION_SLIDEINDOWN => __("slideInDown"),
			self::ANIMATION_SLIDEINLEFT => __("slideInLeft"),
			self::ANIMATION_SLIDEINRIGHT => __("slideInRight"),
			self::ANIMATION_SLIDEINUP => __("slideInUp")
		];
    }

    public static function getOutAnimations(){
    	return [
			self::ANIMATION_NONE => __("None"),
			self::ANIMATION_BOUNCE => __("bounce"),
			self::ANIMATION_FLASH => __("flash"),
			self::ANIMATION_PULSE => __("pulse"),
			self::ANIMATION_RUBBERBAND => __("rubberBand"),
			self::ANIMATION_SHAKE => __("shake"),
			self::ANIMATION_HEADSHAKE => __("headShake"),
			self::ANIMATION_TADA => __("tada"),
			self::ANIMATION_WOBBLE => __("wobble"),
			self::ANIMATION_JELLO => __("jello"),
			self::ANIMATION_SWING => __("swing"),
			self::ANIMATION_BOUNCEOUT => __("bounceOut"),
			self::ANIMATION_BOUNCEOUTDOWN => __("bounceOutDown"),
			self::ANIMATION_BOUNCEOUTLEFT => __("bounceOutLeft"),
			self::ANIMATION_BOUNCEOUTRIGHT => __("bounceOutRight"),
			self::ANIMATION_BOUNCEOUTUP => __("bounceOutUp"),
			self::ANIMATION_FADEOUT => __("fadeOut"),
			self::ANIMATION_FADEOUTDOWN => __("fadeOutDown"),
			self::ANIMATION_FADEOUTDOWNBIG => __("fadeOutDownBig"),
			self::ANIMATION_FADEOUTLEFT => __("fadeOutLeft"),
			self::ANIMATION_FADEOUTLEFTBIG => __("fadeOutLeftBig"),
			self::ANIMATION_FADEOUTRIGHT => __("fadeOutRight"),
			self::ANIMATION_FADEOUTRIGHTBIG => __("fadeOutRightBig"),
			self::ANIMATION_FADEOUTUP => __("fadeOutUp"),
			self::ANIMATION_FADEOUTUPBIG => __("fadeOutUpBig"),
			self::ANIMATION_ANIMATEDFLIP => __("animatedflip"),
			self::ANIMATION_FLIPOUTX => __("flipOutX"),
			self::ANIMATION_FLIPOUTY => __("flipOutY"),
			self::ANIMATION_LIGHTSPEEDOUT => __("lightSpeedOut"),
			self::ANIMATION_ROTATEOUT => __("rotateOut"),
			self::ANIMATION_ROTATEOUTDOWNLEFT => __("rotateOutDownLeft"),
			self::ANIMATION_ROTATEOUTDOWNRIGHT => __("rotateOutDownRight"),
			self::ANIMATION_ROTATEOUTUPLEFT => __("rotateOutUpLeft"),
			self::ANIMATION_ROTATEOUTUPRIGHT => __("rotateOutUpRight"),
			self::ANIMATION_ROLLOUT => __("rollOut"),
			self::ANIMATION_ZOOMOUT => __("zoomOut"),
			self::ANIMATION_ZOOMOUTDOWN => __("zoomOutDown"),
			self::ANIMATION_ZOOMOUTLEFT => __("zoomOutLeft"),
			self::ANIMATION_ZOOMOUTRIGHT => __("zoomOutRight"),
			self::ANIMATION_ZOOMOUTUP => __("zoomOutUp"),
			self::ANIMATION_SLIDEOUTDOWN => __("slideOutDown"),
			self::ANIMATION_SLIDEOUTLEFT => __("slideOutLeft"),
			self::ANIMATION_SLIDEOUTRIGHT => __("slideOutRight"),
			self::ANIMATION_SLIDEOUTUP => __("slideOutUp")
		];
    }
    
}
