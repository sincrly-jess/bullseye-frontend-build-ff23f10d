import background from "@/assets/background.png";
import { Button } from "@/components/ui/button";
import { Sparkles, Gamepad2, Users } from "lucide-react";

const HeroSection = () => {
  return (
    <section className="relative min-h-[60vh] flex items-center justify-center overflow-hidden pt-16">
      {/* Background image */}
      <img
        src={background}
        alt=""
        className="absolute inset-0 w-full h-full object-cover"
      />
      <div className="absolute inset-0 bg-background/60" />

      {/* Content */}
      <div className="relative z-10 container mx-auto px-4 text-center py-16">
        <h1 className="font-display text-4xl md:text-6xl font-black tracking-tight mb-4 text-glow">
          <span className="text-foreground">Welcome to</span>
          <br />
          <span className="gradient-text">Bullseye</span>
        </h1>

        {/* Login prompt */}
        <div className="inline-block glass rounded-xl px-6 py-3 mb-10">
          <p className="text-muted-foreground text-sm">
            Sorry, you have to login to access the games!
          </p>
        </div>

        {/* Why Choose Bullseye */}
        <div className="max-w-2xl mx-auto text-left mb-12">
          <h2 className="font-display text-2xl md:text-3xl font-bold mb-6">
            <span className="text-primary">Why Choose</span>{" "}
            <span className="text-foreground">Bullseye?</span>
          </h2>

          <div className="space-y-5">
            <div>
              <h3 className="text-foreground font-semibold flex items-center gap-2 mb-1">
                <Sparkles className="w-4 h-4 text-primary" /> Thrill Without the Risk
              </h3>
              <p className="text-muted-foreground text-sm leading-relaxed">
                Experience the excitement of gambling with zero financial danger. Bullseye lets users take risks, learn strategy, and have fun — all without losing real money.
              </p>
            </div>

            <div>
              <h3 className="text-foreground font-semibold flex items-center gap-2 mb-1">
                <Gamepad2 className="w-4 h-4 text-primary" /> Play Anytime, Anywhere
              </h3>
              <p className="text-muted-foreground text-sm leading-relaxed">
                Jump into games instantly on web or mobile. Daily rewards, leaderboards, and fast access keep the fun going wherever you are.
              </p>
            </div>

            <div>
              <h3 className="text-foreground font-semibold flex items-center gap-2 mb-1">
                <Users className="w-4 h-4 text-primary" /> Compete, Connect, Improve
              </h3>
              <p className="text-muted-foreground text-sm leading-relaxed">
                Challenge friends, climb rankings, and sharpen decision-making skills. Bullseye turns gambling into a social, skill-based experience where strategy wins.
              </p>
            </div>
          </div>
        </div>

      </div>
    </section>
  );
};
export default HeroSection;
