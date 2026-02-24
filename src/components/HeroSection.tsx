import background from "@/assets/background.png";
import { Button } from "@/components/ui/button";
import { Target, TrendingUp, Zap } from "lucide-react";

const HeroSection = () => {
  return (
    <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
      {/* Background image */}
      <img
        src={background}
        alt=""
        className="absolute inset-0 w-full h-full object-cover"
      />

      {/* Overlay */}
      <div className="absolute inset-0 bg-background/40" />

      {/* Content */}
      <div className="relative z-10 container mx-auto px-4 text-center">
        <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-8">
          <Zap className="w-4 h-4 text-primary" />
          <span className="text-sm text-muted-foreground">Live predictions & games available now</span>
        </div>

        <h1 className="font-display text-5xl md:text-7xl lg:text-8xl font-black tracking-tight mb-6 text-glow">
          <span className="gradient-text">BULLSEYE</span>
        </h1>

        <p className="text-lg md:text-xl text-muted-foreground max-w-2xl mx-auto mb-10 leading-relaxed">
          Predict outcomes. Play games. Win rewards. The ultimate platform for predictions, casino games, and competitive leaderboards.
        </p>

        <div className="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
          <Button size="lg" className="bg-primary text-primary-foreground hover:bg-primary/90 px-8 py-6 text-lg font-semibold box-glow">
            Start Playing
          </Button>
          <Button size="lg" variant="outline" className="border-border text-foreground hover:bg-secondary px-8 py-6 text-lg">
            Explore Games
          </Button>
        </div>

        {/* Stats */}
        <div className="flex flex-wrap items-center justify-center gap-8 md:gap-16">
          <div className="text-center">
            <div className="flex items-center justify-center gap-2 mb-1">
              <Target className="w-5 h-5 text-primary" />
              <span className="font-display text-2xl md:text-3xl font-bold text-foreground">50K+</span>
            </div>
            <span className="text-sm text-muted-foreground">Active Players</span>
          </div>
          <div className="text-center">
            <div className="flex items-center justify-center gap-2 mb-1">
              <TrendingUp className="w-5 h-5 text-primary" />
              <span className="font-display text-2xl md:text-3xl font-bold text-foreground">$2M+</span>
            </div>
            <span className="text-sm text-muted-foreground">Rewards Given</span>
          </div>
          <div className="text-center">
            <div className="flex items-center justify-center gap-2 mb-1">
              <Zap className="w-5 h-5 text-primary" />
              <span className="font-display text-2xl md:text-3xl font-bold text-foreground">100+</span>
            </div>
            <span className="text-sm text-muted-foreground">Games Available</span>
          </div>
        </div>
      </div>
    </section>
  );
};

export default HeroSection;
