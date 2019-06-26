import Config from "../config/Config.js";
import Rain from "../animations/bg-canvas/rain/Rain.js";
import WanderingCircles from "./bg-canvas/wanderingCircles/WanderingCircles.js";

export default () => {

  if (Config.get('BG_ANIMATION')) {
    const canvas = <HTMLCanvasElement>document.getElementById('bg-canvas')
    if (!canvas) return;

    switch(Config.get('BG_ANIMATION')) {
      case 1:
        return new Rain(canvas);
      case 2:
        return new WanderingCircles(canvas);
    }
  }

}
